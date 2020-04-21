<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class CartController extends Controller {

    protected $cartModel;
    protected $cartItemModel;

    public function __construct( Cart $cartModel, CartItem $cartItemModel )
    {
        $this->cartModel = $cartModel;
        $this->cartItemModel = $cartItemModel;
    }

    public function restoreCart()
    {
        $user = Auth::guard( 'api' )->user();

        if($user)
        {
            $getCart = Cart::where( 'user_id', $user->id )->first();
            $getItems = [];
            foreach ($getCart->cartItems as $item)
            {
                $getItems[] = [
                    'item_name'            => $item->item_name,
                    'product_attribute_id' => $item->product_attribute_value_id,
                    'product_image'        => $item->item_image,
                    'product_qty'          => $item->qty,
                    'product_color_name'   => $item->color_name,
                    'product_price'        => $item->unit_price,
                    'print_image'          => $item->print_image
                ];
            }

            $cart = [
                'items'    => $getItems,
                'subtotal' => $getCart->subtotal,
                'discount' => $getCart->discount,
                'total'    => $getCart->total,
            ];

            return $cart;
        }

        return 'Unauthorized 999';
    }

    // save cart items in DB
    public function storeItem( Request $request )
    {
        $photo = $request->only( 'file' );
        $printImage = '';
        if ( $request->hasFile( 'file' ) )
        {
            //save image
            $imageName = $photo['file']->getClientOriginalName();
            $filename = pathinfo($imageName, PATHINFO_FILENAME);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);
            $filename = Str::slug($filename, '-');

            $printImage = $filename .'.'. $extension;

            Image::make( $photo['file'] )
                ->encode( 'jpg' )
                ->save( 'uploads/print_images/' . $printImage );
        }

        $user = Auth::user();
        if ( !$user->cart )
        {
            $attributesCart = $request->only( [
                'total', 'discount'
            ] );

            $user->cart = $this->cartModel->createNewCart( $user->id, $attributesCart );
        }

        $attributesCartItem = $request->only( [
            'item_name',
            'product_attribute_id',
            'product_image',
            'product_qty',
            'product_color_name',
            'product_price',
            'product_discount',
        ] );

        $attributesCartItem['print_image'] = '';
        if ( $request->hasFile( 'file' ) )
        {
            $attributesCartItem['print_image'] = 'uploads/print_images/' . $printImage;
        }

        $this->cartItemModel->handleCartItem( $user->cart->id, $attributesCartItem );

        if ( $request->hasFile( 'file' ) )
        {
            return ['fileName' => $printImage,
                    'item' => [
                        'item_name' => $attributesCartItem['item_name'],
                        'product_attribute_id'=> $attributesCartItem['product_attribute_id'],
                        'product_image'=> $attributesCartItem['product_image'],
                        'product_qty'=> $attributesCartItem['product_qty'],
                        'product_color_name'=> $attributesCartItem['product_color_name'],
                        'product_price'=> $attributesCartItem['product_price'],
                        'product_discount'=> $attributesCartItem['product_discount'],
                        ]
            ];
        }
    }

    public function updateItem( Request $request )
    {
        $user = Auth::user();

        if ( !$user->cart->id )
        {
            return 'Cart not created yet!';
        }
        $attributesCartItem = $request->only( [
            'product_attribute_id',
            'product_qty',
            'product_price'
        ] );

        $this->cartItemModel->updateItemQty( $user->cart->id, $attributesCartItem );
    }

    public function removeItem( Request $request )
    {
        $user = Auth::user();

        if ( !isset( $user->cart->id ) )
        {
            return 'Cart not created yet!';
        }

        $attributesCartItem = $request->only( [
            'product_attribute_id',
            'print_image'
        ] );

        if(isset($attributesCartItem['print_image'])){

            $this->cartItemModel->removeItem( $user->cart->id, $attributesCartItem['product_attribute_id'], $attributesCartItem['print_image'] );
        }else{

            $this->cartItemModel->removeItem( $user->cart->id, $attributesCartItem['product_attribute_id'], '' );
        }
    }

}
