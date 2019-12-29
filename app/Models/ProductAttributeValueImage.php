<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValueImage extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function productAttributeValue()
    {
        return $this->belongsTo(ProductAttributeValue::class);
    }
}
