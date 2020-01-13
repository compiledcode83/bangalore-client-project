<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BestSellerController extends Controller
{
    public function homeBestSeller()
    {
        $products = DB::table('products')
            ->leftJoin('product_attribute_values','products.id','=','product_attribute_values.product_id')
            ->leftJoin('order_items','product_attribute_values.id','=','order_items.product_attribute_value_id')
            ->selectRaw('products.*, COALESCE(sum(order_items.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->take(12)
            ->get();

        return $products;
    }
}
