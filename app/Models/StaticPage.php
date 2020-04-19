<?php

namespace App\Models;

use App\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use SoftDeletes, LocaleTrait;

    const TYPE_ABOUT_US = 'about_us';
    const TYPE_CONTACT_US = 'contact_us';
    const TYPE_General = 'general';

    /**
     * The attributes that should be mutated locale.
     * @var array
     */
    protected $localeStrings = ['title','body'];

    protected $guarded = ['id'];
}
