<?php

namespace App\Http\Controllers\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BestSellerController extends Controller
{
    public function homeBestSeller()
    {
        $user = Auth::guard('api')->user();
        $products = DB::table('products')
            ->leftJoin('product_attribute_values','products.id','=','product_attribute_values.product_id')
            ->leftJoin('order_items','product_attribute_values.id','=','order_items.product_attribute_value_id')
            ->selectRaw('products.*, COALESCE(sum(order_items.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->take(12)
            ->where('products.is_active', '=', '1')
            ->get();

//        dd($products);

        $newProducts = [];
        if($user)
        {
            $productModel = new Product();
            foreach ($products as $product)
            {
                $newProduct = Product::find($product->id);

                if($newProduct && $newProduct->prices->first())
                {
                    //load prices
                    $priceTable = [];
                    foreach ($newProduct->prices as $price)
                    {
                        if ( $user->type == User::TYPE_USER )
                        {
                            $discountPrice = null;
                            if ( $price->individual_discounted_unit_price && $price->individual_discounted_unit_price != '0' )
                            {
                                $discountPrice = $price->individual_discounted_unit_price;
                            }
                            $priceTable[$price->max_qty] = [
                                'baseOriginal'    => $price->individual_unit_price,
                                'discount' => $price->individual_discounted_unit_price
                            ];
                        }

                        if ( $user->type == User::TYPE_CORPORATE )
                        {
                            $discountPrice = null;
                            if ( $price->corporate_discounted_unit_price && $price->corporate_discounted_unit_price != '0' )
                            {
                                $discountPrice = $price->corporate_discounted_unit_price;
                            }
                            $priceTable[$price->max_qty] = [
                                'baseOriginal'    => $price->corporate_unit_price,
                                'discount' => $price->corporate_discounted_unit_price
                            ];
                        }
                    }

                    $priceTable = collect($priceTable);
                    $newProduct->price = $priceTable->first();

                    $newProducts[] = $newProduct;
                }
            }

            return $newProducts;
        }

        return $products;
    }

    public function bestSeller()
    {
        $products = DB::table('products')
            ->leftJoin('product_attribute_values','products.id','=','product_attribute_values.product_id')
            ->leftJoin('order_items','product_attribute_values.id','=','order_items.product_attribute_value_id')
            ->selectRaw('products.*, COALESCE(sum(order_items.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->take(15)
            ->where('products.is_active', '=', '1')
            ->get();

        return $products;
    }
}
