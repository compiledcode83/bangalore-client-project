<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Review;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\File;

class UserController extends Controller {

    protected $userModel;

    public function __construct( User $userModel)
    {
        $this->userModel = $userModel;
    }

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

    public function accountInfo()
    {
        $account = Auth::user();

        return $account;
    }

    public function updateAccountInfo(Request $request)
    {
        $user = Auth::user();
        $license = $request->only('file');

        $licensePdf = '';
        if($request->hasFile('file'))
        {
            //save $license
            $licenseName =  Str::random(15);
            $licensePdf = $licenseName . '.pdf';

            $request->file('file')->move(public_path('/uploads/accounts/'), $licensePdf);
        }

        $attributes = $request->only( [
            'first_name',
            'last_name',
            'company',
            'job_title',
            'contact_person',
            'phone',
            'email',
        ] );

        if($request->hasFile('file'))
        {
            $attributes['company_license'] = 'uploads/accounts/'.$licensePdf;
        }

        if($this->userModel->updateUserAccount($user->id, $attributes))
        {
            return ['message' => 'Information updated'];
        }

        return ['error' => 'Server Error'];
    }

    public function accountWishlist()
    {
        $user = Auth::user();

        $productsIds = $user->wishLists->pluck('product_id');
        $productModel = new Product();
        $products = $productModel->whereIn('id', $productsIds)->get();

        return $productModel->getProductsRatingColors($products);
    }

    public function storeAccountWishlist(Request $request)
    {
        $user = Auth::user();
        $attribute = $request->only('productId');

        $check = WishList::where('user_id', $user->id)
                    ->where('product_id', $attribute['productId'])
                    ->first();
        if(!$check)
        {
            WishList::create([
                'user_id' => $user->id,
                'product_id' => $attribute['productId']
            ]);
        }
    }

    public function accountRemoveWishlistItem($id)
    {
        $user = Auth::user();

        WishList::where('user_id', $user->id)
                ->where('product_id', $id)
                ->delete();

        return $this->accountWishlist();
    }
}
