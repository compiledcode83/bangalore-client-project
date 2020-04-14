<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserAddress;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\OrderStatus;
class OrderTransactions extends Model
{
    protected $table = 'order_transactions';
    protected $fillable = ['order_id', 'payment_id','result','auth','reference','track_id','tran_id','amount' ,'currency' ,'time' ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
