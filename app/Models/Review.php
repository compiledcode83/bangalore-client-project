<?php

namespace App\Models;

use App\ReviewAbus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Get the product owns this review
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user owns this review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order owns this review
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get Abuses for review.
     */
    public function abuses()
    {
        return $this->hasMany(ReviewAbuse::class);
    }

    public function getTotalRateAttribute()
    {
        $reviews = Review::where('product_id', $this->product_id)->get();
//        $count   = $reviews->count();
        $totalRating= ceil($reviews->sum('rating')/2);

        return '4';
    }
}
