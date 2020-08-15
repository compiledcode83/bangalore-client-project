<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;

    protected $table = 'order_status';

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

    public function status()
    {
        return $this->belongsTo(Status::class,'status_id','id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
