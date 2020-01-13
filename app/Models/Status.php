<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the order owns this item
     */
    public function order()
    {
        return $this->belongsToMany(Order::class);
    }
}
