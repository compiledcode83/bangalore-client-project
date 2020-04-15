<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\OrderTransactions;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class OrderController extends Controller {

    protected $orderModel;

    public function __construct( Order $orderModel )
    {
        $this->orderModel = $orderModel;
    }

    public function store( Request $request )
    {
        $user = Auth::user();
        $attributes = $request->only( 'discount','delivery','shippingAddress', 'billingShipping', 'paymentMethod', 'defaultBillingAddress' );

        $order = $this->orderModel->store( $user, $attributes );
        $orderProduct = [];
        if($request->paymentMethod == 'cash')
        {
            return (['cod'=>true , 'orderCode'=>$order->order_code]);
        }
        foreach($order->orderitems as $item)
        {
             array_push($orderProduct , array (
                'CurrencyCode' => 'KWD',
                'Quantity' => $item->qty,
                'TotalPrice' => $item->qty * $item->unit_price,
                'UnitID' => $item->product_attribute_value_id,
                'UnitName' => $item->productAttributeValue->product->name,
                'UnitPrice' => $item->unit_price,
                'VndID' => '',
            ));
        }
        if ( $order )
        {
            $fields = array (
                'CustomerDC' =>
                    array (
                        'Email' => $user->email,
                        'Floor' => '4',
                        'Gender' => 'F',
                        'ID' => $user->id,
                        'Mobile' => $user->phone,
                        'Name' => $user->first_name .' '. $user->last_name,
                        'Nationality' => '',
                        'Street' => '',
                        'Area' => '',
                        'CivilID' => '',
                        'Building' => '',
                        'Apartment' => '',
                        'DOB' => '',
                    ),
                'lstProductDC' =>$orderProduct
                     ,
                'lstGateWayDC' =>
                    array (
                        0 =>
                            array (
                                'Name' => 'ALL',
                            ),
                    ),
                'MerMastDC' =>
                    array (
                        'AutoReturn' => 'Y',
                        'ErrorURL' =>  env("TAP_PAYMENT_ReturnURL").$order->id,
                        'HashString' => env("TAP_PAYMENT_HASH"),
                        'LangCode' => 'EN',
                        'MerchantID' => env("TAP_PAYMENT_MerchantID"),
                        'Password' =>  env("TAP_PAYMENT_PASSWORD"),
                        'PostURL' =>  env("TAP_PAYMENT_ReturnURL").$order->id,
                        'ReferenceID' => '45870225000',
                        'ReturnURL' =>  env("TAP_PAYMENT_ReturnURL").$order->id,
                        'UserName' => env("TAP_PAYMENT_USERNAME"),
                    ),
            );
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://tapapi.gotapnow.com/TapWebConnect/Tap/WebPay/PaymentRequest",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response);

                return (['cod'=>false , 'PaymentUrl'=>$response->PaymentURL]);
            }
            return (['cod'=>true , 'orderCode'=>$order->order_code]);

        }

        return 'server error!';
    }

    public function paymentReturn (Request $request)
    {
        $orderTransaction = OrderTransactions::firstOrCreate(['order_id' => $request->code],['order_id' => $request->code,
            'payment_id' => $request->payid,
            'result' => $request->result,
            'auth' => $request->Auth,
            'reference' => $request->ref,
            'track_id' => $request->trackid ? $request->trackid : 0,
            'tran_id' => isset($request->TranID) ? $request->TranID : 0,
            'amount' => $request->amt,
            'currency' => 414,
            'time' => Carbon::now()->format('h:s:i')]);

        $order = Order::with( 'OrderStatus.Status','orderTransactions','orderItems', 'orderItems.productAttributeValue', 'orderItems.productAttributeValue.product', 'orderItems.productAttributeValue.attributeValue' )
            ->where( 'id', $request->code )
//            ->where( 'user_id', Auth::Id())
            ->first();
        if($request->result=='SUCCESS')
        {
            OrderStatus::create(
                [
                    'order_id'=>$request->code,
                    'status_id'=>Order::IS_PAID
                ]
            );
            $order->update(['final_status'=>Status::whereId(Order::IS_PAID)->first()->name_en]);
        }
        else
        {
            OrderStatus::create(
                [
                    'order_id'=>$request->code,
                    'status_id'=>Order::NOT_PAID
                ]
            );
        }
        if ( !$order )
        {
            return ['error' => 'Not Authorized 291!'];
        }

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
            'payment'   => $order->orderTransactions->last(),
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
            'total'    => $order->total,
            'subTotal'    => $order->sub_total,
            'discount'    => $order->total_discount,
            'delivery'    => $order->delivery_charges,
            'created'  => $order->created_at->format('Y-m-d H:i:s'),
            'customer' => $order->user->full_name,
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
                    $productController = new ProductController( new Product() );
                    $productPrices = $productController->productPrices( $item->productAttributeValue->product->slug );
                    $items[] = [
                        'item_name'            => $item->productAttributeValue->product->name_en,
                        'product_attribute_id' => $item->product_attribute_value_id,
                        'product_image'        => $item->productAttributeValue->main_images[0],
                        'product_print_image'  => $item->print_image,
                        'product_qty'          => $item->qty,
                        'product_color_name'   => $item->productAttributeValue->attributeValue->value_en,
                        'product_price'        => $item->unit_price,
                        'base_product_prices'  => $productPrices['priceTable'],
                        'total'                => $item->unit_price * $item->qty,
                        'status'               => false,
                        'stock'                => $item->productAttributeValue->stock
                    ];
                }
                else
                {
                    return ['error' => 'requested qty not available'];
                }
            }
            else
            {
                return ['error' => 'We are sorry product not available!'];
            }
        }

        return ['items' => $items];
    }

    public function getUserOrderStatuses( $id )
    {
        $order = Order::with( 'orderStatuses' )->where( 'id', $id )->first();

        return $order;
    }
}
