<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function userReviews()
    {
        $user = Auth::user();
        $reviews = Review::where( 'user_id', $user->id )->get();
        $responseData = [];

        foreach ($reviews as $review)
        {
            $product = Product::find( $review->product_id );
            $responseData [] = [
                'productTitle' => $product->name_en,
                'productImage' => $product->main_image,
                'rate'         => $review->rating,
                'review'       => $review->review,
                'created'      => $review->created_at->format('M d, Y g:i a'),
            ];
        }

        return $responseData;
    }

    public function userAbleToReview( $productAttributeId )
    {
        $user = Auth::user();
        $ability = '';

        $userOrders = Order::where( 'user_id', $user->id )->get();
        foreach ($userOrders as $order)
        {
            foreach ($order->orderItems as $item)
            {
                if ( $item->product_attribute_value_id == $productAttributeId )
                {
                    $productAttribute = ProductAttributeValue::find( $item->product_attribute_value_id );
                    $findReview = Review::where( 'user_id', $user->id )
                        ->where( 'product_id', $productAttribute->product->id )
                        ->first();
                    if ( $findReview )
                    {
                        $ability = 'found';
                        break;
                    }
                    $ability = 'review';
                    break;
                }
            }
        }

        return ['ability' => $ability];
    }

    public function reviewStore( Request $request )
    {
        $attributes = $request->only( 'productAttributeId', 'rate', 'nickname', 'review' );
        $productAttribute = ProductAttributeValue::find( $attributes['productAttributeId'] );
        $user = Auth::user();
        $review = Review::create( [
            'user_id'    => $user->id,
            'product_id' => $productAttribute->product->id,
            'rating'     => $attributes['rate'],
            'review'     => $attributes['review'],
        ] );

        if ( $review )
        {
            return ['message' => 'success'];
        }

        return ['error' => 'Error review#255'];
    }
}
