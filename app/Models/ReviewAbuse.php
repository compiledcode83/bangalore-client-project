<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAbuse extends Model
{
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
