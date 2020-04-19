<?php

namespace App\Models;

use App\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes, LocaleTrait;

    /**
     * The attributes that should be mutated locale.
     * @var array
     */
    protected $localeStrings = ['title','description'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_en', 'title_ar', 'description_en','description_ar','is_active'
    ];
}
