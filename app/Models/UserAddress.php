<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'user_id'];

    /**
     * Get the user owns this address
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
