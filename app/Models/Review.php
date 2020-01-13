<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalRateAttribute()
    {
        $reviews = Review::where('product_id', $this->product_id)->get();
//        $count   = $reviews->count();
        $totalRating= ceil($reviews->sum('rating')/2);

        return '4';
    }
}
