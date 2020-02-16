<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class CartController extends Controller
{
    protected $cartModel;
    protected $cartItemModel;

    public function __construct( Cart $cartModel, CartItem $cartItemModel )
    {
        $this->cartModel = $cartModel;
        $this->cartItemModel = $cartItemModel;
    }

    // save cart items in DB
    public function storeItem(Request $request)
    {
        $photo = $request->only('file');
        $printImage = '';
        if($request->hasFile('file'))
        {
            //save image
            $imageName = str_random(15);
            $printImage = $imageName . '.jpg';

            Image::make($photo['file'])
                ->encode('jpg')
                    ->save('uploads/print_images/' . $printImage);
        }

        $user = Auth::user();
        if(!$user->cart)
        {
            $attributesCart = $request->only( [
                'total', 'discount'
            ] );

            $user->cart = $this->cartModel->createNewCart($user->id, $attributesCart);
        }

        $attributesCartItem = $request->only( [
            'item_name',
            'product_attribute_id',
            'product_image',
            'product_qty',
            'product_color_name',
            'product_price'
        ] );

        if($request->hasFile('file'))
        {
            $attributesCartItem['print_image'] = 'uploads/print_images/'.$printImage;
        }

        $this->cartItemModel->handleCartItem($user->cart->id, $attributesCartItem);

        if($request->hasFile('file'))
        {
            return ['fileName' => $printImage];
        }
    }

    public function updateItem(Request $request)
    {
        $user = Auth::user();

        if(!$user->cart->id)
        {
            return 'Cart not created yet!';
        }
        $attributesCartItem = $request->only( [
            'product_attribute_id',
            'product_qty',
            'product_price'
        ] );

        $this->cartItemModel->updateItemQty($user->cart->id, $attributesCartItem);
    }

}
