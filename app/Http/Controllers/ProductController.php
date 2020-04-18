<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {

    protected $productModel;

    public function __construct( Product $productModel )
    {
        $this->productModel = $productModel;
    }

    public function productDetails( $slug, Request $request )
    {
        $user = Auth::guard('api')->user();
        $product = Product::with( 'productAttributeValues', 'reviews' )
            ->where( 'slug', $slug )
            ->first();

        //add colors
        $colors = [];
        if ( $product->productAttributeValues->first() )
        {
            foreach ($product->productAttributeValues as $productAttributeValue)
            {
                if ( isset( $productAttributeValue->attributeValue->other_value ) )
                {
                    $colors [$productAttributeValue->id] = [
                        'color_code' => $productAttributeValue->attributeValue->other_value,
                        'name'       => $productAttributeValue->attributeValue->value_en,
                        'images'     => $productAttributeValue->main_images
                    ];
                }
            }
        }
        $product->colors = $colors;

        if ( isset($product->reviews) && $product->reviews->first() )
        {
            $reviews = $product->reviews;
            $count = $reviews->count();
            if ( $count )
            {
                $product->rating = ceil( $reviews->sum( 'rating' ) / $count );
            }
        }

        $relatedProductsDetails = [];

        //related product details
        foreach ($product->related as $relatedProduct)
        {
            $findProduct = Product::find( $relatedProduct );
            if ( $findProduct &&  $findProduct->is_active)
            {
                $this->productModel->addProductBasePrice($findProduct, $user);
                $relatedProductsDetails [] = $findProduct;
            }
        }
        $product->relatedProductsDetails = $this->productModel->getProductsRatingColors( $relatedProductsDetails );

        return $product;
    }

    public function productPrices( $slug )
    {
        $product = Product::with( 'prices' )
            ->where( 'slug', $slug )
            ->first();

        //load prices
        $priceTable = [];
        $priceTableWithDiscounts = [];
        $originalPrice = 0;
        $discountFound = false;

        $discountEnabled = Setting::find(1);
        $checkDiscountEnabled = $discountEnabled->enable_offers_page;
        foreach ($product->prices as $price)
        {
            if ( Auth::user()->type == User::TYPE_USER )
            {
                $discountPrice = null;
                if ( $price->individual_discounted_unit_price && $price->individual_discounted_unit_price != '0' )
                {
                    $discountPrice = $price->individual_discounted_unit_price;
                }
                $basePrice = $discountPrice ?? $price->individual_unit_price;
                $originalPrice = $price->individual_unit_price;
                $discountFound = $discountPrice ? true : false;

                if(!$checkDiscountEnabled)
                {
                    $basePrice = $price->individual_unit_price;
                    $discountPrice = null;
                    $discountFound = false;
                    $priceTableWithDiscounts[$price->max_qty] = [
                        'price'    => $price->individual_unit_price,
                        'discount' => 0
                    ];
                }
                else
                {
                    $priceTableWithDiscounts[$price->max_qty] = [
                        'price'    => $price->individual_unit_price,
                        'discount' => $price->individual_discounted_unit_price
                    ];
                }
                $priceTable [$price->max_qty] = $basePrice;

            }

            if ( Auth::user()->type == User::TYPE_CORPORATE )
            {
                $discountPrice = null;
                if ( $price->corporate_discounted_unit_price && $price->corporate_discounted_unit_price != '0' )
                {
                    $discountPrice = $price->corporate_discounted_unit_price;
                }
                $basePrice = $discountPrice ?? $price->corporate_unit_price;
                $originalPrice = $price->corporate_unit_price;
                $discountFound = $discountPrice ? true : false;

                if(!$checkDiscountEnabled)
                {
                    $basePrice = $price->corporate_unit_price;
                    $discountPrice = null;
                    $discountFound = false;
                    $priceTableWithDiscounts[$price->max_qty] = [
                        'price'    => $price->corporate_unit_price,
                        'discount' => 0
                    ];
                }
                else
                {
                    $priceTableWithDiscounts[$price->max_qty] = [
                        'price'    => $price->corporate_unit_price,
                        'discount' => $price->corporate_discounted_unit_price
                    ];
                }
                $priceTable [$price->max_qty] = $basePrice;

            }
        }

        return [
            'priceTable'             => $priceTable,
            'priceTableWithDiscount' => $priceTableWithDiscounts,
            'originalPrice'          => $originalPrice,
            'discountFound'          => $discountFound
        ];
    }

    public function searchProducts( $term )
    {
        $user = Auth::guard('api')->user();
        $products = $this->productModel->search( $term );
        $products = $this->productModel->addPrices($products, $user);


        return $this->productModel->getProductsRatingColors( $products );
    }

    public function onlyOffers(Request $request)
    {
        $wishList = [];
        $user = Auth::guard('api')->user();
        if($user)
        {
            //get user wishList
            $wishList = $user->wishLists->pluck('product_id')->toArray();
        }

        $filterOptions = $request->query();

        $query = Product::whereHas('prices', function ($query) use ($user, $filterOptions) {

            if ( $user->type == User::TYPE_USER )
            {
                $query->where('individual_discounted_unit_price', '!=', NULL);
                $query->orWhere('individual_discounted_unit_price', '!=', '0');
                if(isset($filterOptions['term']))
                {
                    $query->where(function($query) use ($filterOptions){
                        $query->where('name_en', 'LIKE', '%'. $filterOptions['term'] .'%')
                            ->orWhere('name_ar', 'LIKE', '%'. $filterOptions['term'] .'%');
                    });
                }
            }

            if ( $user->type == User::TYPE_CORPORATE )
            {
                $query->where('corporate_discounted_unit_price', '!=', NULL);
//                $query->orWhere('corporate_discounted_unit_price', '!=', '0');
                if(isset($filterOptions['term']))
                {
                    $query->where(function($query) use ($filterOptions){
                        $query->where('name_en', 'LIKE', '%'. $filterOptions['term'] .'%')
                            ->orWhere('name_ar', 'LIKE', '%'. $filterOptions['term'] .'%');
                    });
                }
            }
        });

        if(isset($filterOptions['sort']))
        {
            $products = $query->active()->orderBy( 'name_en', $filterOptions['sort'] )->paginate(9);
        }
        else
        {
            $products = $query->active()->orderBy( 'created_at', 'desc' )->paginate(12);
//            dd($products);
        }

        if ( !empty($products ))
        {
            $productModel = new Product();

            $products = $productModel->getProductsRatingColors($products);
            $products = $this->addWishListedProducts($products, $wishList);
            $products = $this->addDiscountsProducts($products, $user);
            $products = $productModel->addPrices($products, $user);

            $response = [
                'products' => $products,
            ];

            return response()->json( $response );
        }

        return [];
    }

    public function addWishListedProducts($products, $wishList)
    {
        foreach ($products as $product)
        {
            if(in_array($product->id, $wishList))
            {
                $product->whishlisted = 1;
            }
            else
            {
                $product->whishlisted = 0;
            }
        }

        return $products;
    }

    public function addDiscountsProducts($products, $user)
    {
        foreach ($products as $product)
        {
            $discounts = [];
            foreach ($product->prices as $price)
            {
                if ( $user->type == User::TYPE_USER )
                {
                    if ( $price->individual_discounted_unit_price && $price->individual_discounted_unit_price != '0' )
                    {
                        $discounts [] = (($price->individual_unit_price - $price->individual_discounted_unit_price) / $price->individual_unit_price) * 100;
                    }
                }

                if ( $user->type == User::TYPE_CORPORATE )
                {
                    if ( $price->corporate_discounted_unit_price && $price->corporate_discounted_unit_price != '0' )
                    {
                        $discounts [] = (($price->corporate_unit_price - $price->corporate_discounted_unit_price) / $price->corporate_unit_price) * 100;
                    }
                }
            }
            if(!empty($discounts))
            {
                $product->discount = number_format(max($discounts), 0);
            }
        }

        return $products;
    }
}
