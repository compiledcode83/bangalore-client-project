<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $guarded = ['id', 'user_id'];

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
        return $this->hasMany(OrderStatus::class);
    }
}
