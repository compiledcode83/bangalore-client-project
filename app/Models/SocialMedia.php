<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['created_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];
}
