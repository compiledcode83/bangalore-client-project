<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
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
     * Get the cart owns this item
     */
    public function cart()
    {
        return $this->belongsTo( Cart::class );
    }

    public function handleCartItem( $cartId, $attributes )
    {
        $checkItem = Self::where('cart_id', $cartId)
            ->where('product_attribute_value_id', $attributes['product_attribute_id'])->first();

        if($checkItem)
        {
            if($checkItem->qty == $attributes['product_qty'])
            {
                return 'Item already added!';
            }
            //update Item qty
            $checkItem->update([
                'qty' => $attributes['product_qty']
            ]);

            return 'Item updated successfully!';
        }

        $cartItem = [
            'cart_id'                    => $cartId,
            'product_attribute_value_id' => $attributes['product_attribute_id'],
            'item_name'                  => $attributes['item_name'],
            'item_image'                 => $attributes['product_image'],
            'qty'                        => $attributes['product_qty'],
            'color_name'                 => $attributes['product_color_name'],
            'unit_price'                 => $attributes['product_price'],
        ];
        if(isset($attributes['print_image']))
        {
            $cartItem['print_image'] = $attributes['print_image'];
        }

        Self::create( $cartItem );
        return 'Item Added successfully!';
    }

    public function updateItemQty( $cartId, $attributes )
    {
        $item = Self::where('cart_id', $cartId)
            ->where('product_attribute_value_id', $attributes['product_attribute_id'])->first();

        if($item)
        {
            //update Item qty
            $item->update([
                'qty' => $attributes['product_qty'] + $item->qty,
                'unit_price' => $attributes['product_price']
            ]);

            return 'Item updated successfully!';
        }

        return 'Server Error CI2202!';
    }
}
