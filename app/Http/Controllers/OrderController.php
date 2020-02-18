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

    public function getUserOrders()
    {
        $user = Auth::user();
        return $user->orders->sortByDesc('created_at')->values()->all();
    }

    public function getUserOrderDetails($id)
    {
        $user = Auth::user();
        $order = Order::with('orderItems', 'orderItems.productAttributeValue', 'orderItems.productAttributeValue.product', 'orderItems.productAttributeValue.attributeValue')
                        ->where('id', $id)
                        ->where('user_id', $user->id)
                        ->first();

        if(!$order)
        {
            return ['error' => 'Not Authorized 291!'];
        }

        return $order;
    }

    public function tryToReorder(Request $request)
    {
        $attribute = $request->only('orderId');
        dd($attribute);

        //return these to store
//        item_name: this.product.name_en,
//        product_attribute_id: this.colorInputs[key],//this.selected_attribute.id,
//        product_image: colorObjectInput.images[0],
//        product_print_image: '',
//        product_qty: parseInt(this.qtyInputs[key]),
//        product_color_name: colorObjectInput.name,
//        product_price: 0,
//        base_product_prices: this.productPrices,
//        total: 0,
//        status: false
    }
}
