<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $product = Product::with( 'productAttributeValues', 'relatedProducts', 'reviews' )
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

        $relatedProductsDetails = [];

        //related product details
        foreach ($product->relatedProducts as $relatedProduct)
        {
            $findProduct = Product::find( $relatedProduct->related_product_id );
            if ( $findProduct )
            {
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
                $priceTable [$price->max_qty] = $basePrice;
                $priceTableWithDiscounts[$price->max_qty] = [
                    'price'    => $price->individual_unit_price,
                    'discount' => $price->individual_discounted_unit_price
                ];
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
                $priceTable [$price->max_qty] = $basePrice;
                $priceTableWithDiscounts[$price->max_qty] = [
                    'price'    => $price->corporate_unit_price,
                    'discount' => $price->corporate_discounted_unit_price
                ];
            }
        }

//        var_dump($originalPrice);
//        var_dump($discountFound);
//        dd($priceTable);

        return [
            'priceTable'             => $priceTable,
            'priceTableWithDiscount' => $priceTableWithDiscounts,
            'originalPrice'          => $originalPrice,
            'discountFound'          => $discountFound
        ];
    }

    public function searchProducts( $term )
    {
        $products = $this->productModel->search( $term );

        return $this->productModel->getProductsRatingColors( $products );
    }
}
