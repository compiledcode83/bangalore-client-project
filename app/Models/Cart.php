<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model {

    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user owns this cart
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Get items for the Cart.
     */
    public function cartItems()
    {
        return $this->hasMany( CartItem::class );
    }

    public function createNewCart( $userId, $attributes )
    {
        $cart = Self::create( [
            'user_id'  => $userId,
            'session_id' => Str::random(20),
            'total'    => $attributes['total'],
            'discount' => $attributes['discount'] ?? 0,
            'subtotal' => $attributes['total'],
        ] );

        return $cart;
    }
}
