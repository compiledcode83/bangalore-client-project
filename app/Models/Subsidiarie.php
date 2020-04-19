<?php

namespace App\Models;

use App\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsidiarie extends Model
{
    use SoftDeletes, LocaleTrait;


    /**
     * The attributes that should be mutated locale.
     * @var array
     */
    protected $localeStrings = ['description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo', 'description_en','description_ar','url','is_active'
    ];
}
