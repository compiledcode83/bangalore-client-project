<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use SoftDeletes;

    const TYPE_ABOUT_US = 'about_us';
    const TYPE_CONTACT_US = 'contact_us';
    const TYPE_General = 'general';

    protected $guarded = ['id'];
}
