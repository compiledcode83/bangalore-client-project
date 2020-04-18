<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewAbuse extends Model
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
     * Get the review owns this abuse
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the user owns this abuse
     */
    public function userBy()
    {
        return $this->belongsTo(User::class);
    }
}
