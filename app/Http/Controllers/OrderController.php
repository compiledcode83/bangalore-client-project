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
            'code'    => $order->order_code,
            'status'  => $order->final_status,
            'address' => $order->address,
            'total'   => $total,
            'created' => $order->created_at,
            'customer' => ($order->user->type == User::TYPE_USER
                ? $order->user->first_name.' '.$order->user->last_name
                : $order->user->company),
            'phone' => $order->user->phone,
            'items'   => $orderItemsResponse
        ];

        return $orderResponse;
    }
}
