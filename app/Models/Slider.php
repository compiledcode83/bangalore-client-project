<?php

namespace App\Models;

use App\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes, LocaleTrait;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at'];

    /**
     * The attributes that should be mutated locale.
     * @var array
     */
    protected $localeStrings = ['title', 'sub_title'];

    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];
}
