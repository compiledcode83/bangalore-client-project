<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {

    protected $orderModel;

    public function __construct( Order $orderModel )
    {
        $this->orderModel = $orderModel;
    }

    public function store()
    {
        $user = Auth::user();

        $order = $this->orderModel->store( $user );

        if ( $order )
        {
            return $order->order_code;
        }

        return 'server error!';
    }

    public function getUserReceipt( $code )
    {
        $user = Auth::user();

        $order = $this->orderModel->getUserOrder( $user, $code );

        $total = 0;
        $orderItemsResponse = [];
        foreach ($order->orderItems as $item)
        {
            $orderItemsResponse [] = [
                'name'  => $item->productAttributeValue->product->name_en,
                'color' => $item->productAttributeValue->attributeValue->value_en,
                'qty'   => $item->qty,
                'price' => $item->unit_price,
                'total' => $item->qty * $item->unit_price,
            ];
            $total += ($item->qty * $item->unit_price);
        }
        $orderResponse = [
            'code'     => $order->order_code,
            'status'   => $order->final_status,
            'address'  => $order->address,
            'total'    => $total,
            'created'  => $order->created_at,
            'customer' => ($order->user->type == User::TYPE_USER
                ? $order->user->first_name . ' ' . $order->user->last_name
                : $order->user->company),
            'phone'    => $order->user->phone,
            'items'    => $orderItemsResponse
        ];

        return $orderResponse;
    }

    public function getUserOrders()
    {
        $user = Auth::user();

        return $user->orders->sortByDesc( 'created_at' )->values()->all();
    }

    public function getUserOrderDetails( $id )
    {
        $user = Auth::user();
        $order = Order::with( 'orderItems', 'orderItems.productAttributeValue', 'orderItems.productAttributeValue.product', 'orderItems.productAttributeValue.attributeValue' )
            ->where( 'id', $id )
            ->where( 'user_id', $user->id )
            ->first();

        if ( !$order )
        {
            return ['error' => 'Not Authorized 291!'];
        }

        return $order;
    }

    public function tryToReorder( Request $request )
    {
        $attribute = $request->only( 'orderId' );
        $order = Order::with( 'orderItems' )->where( 'id', $attribute['orderId'] )->first();
        $items = [];
        foreach ($order->orderItems as $item)
        {
            //check if product & attribute are actives
            if ( $item->productAttributeValue->is_active AND $item->productAttributeValue->product->is_active )
            {
                //check if stock is available
                if ( $item->productAttributeValue->stock >= $item->qty )
                {
                    $items[] = [
                        'item_name'            => $item->productAttributeValue->product->name_en,
                        'product_attribute_id' => $item->product_attribute_value_id,
                        'product_image'        => $item->productAttributeValue->main_images[0],
                        'product_print_image'  => $item->print_image,
                        'product_qty'          => $item->qty,
                        'product_color_name'   => $item->productAttributeValue->attributeValue->value_en,
                        'product_price'        => $item->unit_price,
                        'base_product_prices'  => [],
                        'total'                => $item->unit_price * $item->qty,
                        'status'               => false
                    ];
                }
            }
        }

        return ['items' => $items];
    }

    public function getUserOrderStatuses($id)
    {
        $order = Order::with('orderStatuses')->where('id', $id)->first();

        return $order;
    }
}
