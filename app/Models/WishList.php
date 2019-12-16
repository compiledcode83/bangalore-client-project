<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'user_id', 'product_id'];

    /**
     * Get the user owns this wishList
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
