<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get statuses for the Order.
     */
    public function orderStatuses()
    {
        return $this->belongsToMany(Status::class);
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
    public function store($user)
    {
        $cart = $user->cart;
        $order = new Order( [
            'order_code'  => Str::random(5),
            'final_status' => 'pending',
            'address'    => 'test address',
            'total' => $user->cart->total,
        ] );

        $user->orders()->save($order);

        $items = [];
        foreach($cart->cartItems as $item)
        {
            $items[] = new OrderItem([
                'product_attribute_value_id' => $item->product_attribute_value_id,
                'unit_price' => $item->unit_price,
                'qty' => $item->qty,
                'print_image'    => $item->print_image ?? '',
            ]);
        }
        $saveItems = $order->orderItems()->saveMany($items);

        if($saveItems)
        {
            return $order;
        }

        return false;
    }

    public function getUserOrder($user, $orderCode)
    {
        $order = Self::with('orderItems')->where('user_id', $user->id)
                ->where('order_code', $orderCode)->first();

        return $order;
    }
}
