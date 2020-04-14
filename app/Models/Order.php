<?php

namespace App\Models;

use App\Mail\OrderConfirmation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    const IS_PAID = 5 ; //Status in statues table
    const NOT_PAID = 6 ; //Status in statues table
    /**
     * Get the user owns this wishList
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get items for the Order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    /**
     * Get payment Transaction for the Order.
     */
    public function orderTransactions()
    {
        return $this->hasMany(OrderTransactions::class, 'order_id');
    }

    /**
     * Get statuses for the Order.
     */
    public function OrderStatus()
    {
        return $this->hasMany(OrderStatus::class);
    }

    /**
     * Get Related reviews for the order.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Create new Order.
     * @param $user
     * @return
     */
    public function store($user, $data)
    {
        $cart = $user->cart;
        $order = new Order( [
            'order_code'  => Str::random(5),
            'final_status' => 'pending',
            'address'    => 'test address',
            'total' => $user->cart->total,
            'payment_method' => $data['paymentMethod']
        ] );

        $user->orders()->save($order);

        $items = [];
        $emailConfirmationData = [];
        $itemsTotal = 0;
        foreach($cart->cartItems as $item)
        {
            $check = $this->checkStock($item);
            if(!$check)
            {
                return ['error' => 'order has item out-stock'];
            }
            $items[] = new OrderItem([
                'product_attribute_value_id' => $item->product_attribute_value_id,
                'unit_price' => $item->unit_price,
                'qty' => $item->qty,
                'print_image'    => $item->print_image ?? '',
            ]);

            $itemsTotal += $item->unit_price * $item->qty;

            $emailConfirmationData['items'][] = [
                'name' => $item->item_name,
                'image' => $item->item_image,
                'print_image'    => $item->print_image ?? '',
                'unit_price' => $item->unit_price,
                'qty' => $item->qty,
                'total_price'   => $item->qty * $item->unit_price
            ];
        }
        $emailConfirmationData['subtotal'] = $itemsTotal;
        $emailConfirmationData['order_code'] = $order->order_code;
        $emailConfirmationData['order_date'] = $order->created_at;
        $emailConfirmationData['payment_method'] = $order->payment_method;
        $emailConfirmationData['email'] = $user->email;
        $saveItems = $order->orderItems()->saveMany($items);

        $order->update([
            'total' => $itemsTotal,
        ]);
        if($saveItems)
        {
            $this->updateStock($cart->cartItems);
            $this->deleteCart($cart);
            Mail::to( $user->email )->send( new OrderConfirmation( $emailConfirmationData ) );
            return $order;
        }

        return false;
    }

    protected function deleteCart($userCart)
    {
        $cart = Cart::find($userCart->id);
        $cartItems = CartItem::where('cart_id', $cart->id)->delete();
        $cart->delete();
    }

    protected function checkStock($item)
    {
        $productAttribute = ProductAttributeValue::find($item->product_attribute_value_id);
        if($productAttribute-> stock >= $item->qty)
        {
            return true;
        }

        return false;
    }

    protected function updateStock($items)
    {
        foreach($items as $item)
        {
            $productAttribute = ProductAttributeValue::find($item->product_attribute_value_id);
            $productAttribute->update([
                'stock' => $productAttribute->stock - $item->qty
            ]);
        }
    }

    public function getUserOrder($user, $orderCode)
    {
        $order = Self::with('orderItems')->where('user_id', $user->id)
                ->where('order_code', $orderCode)->first();

        return $order;
    }
}
