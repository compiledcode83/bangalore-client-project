<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function productMainImages()
    {
        return $this->hasMany(ProductMainImage::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class);
    }
}
