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
    protected $dates = ['deleted_at', 'created_at'];


    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Set slug for product from name.
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $slug = str_slug($model->name_en);
            $count = Self::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    /**
     * Get Categories for the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get Attributes Values for the product.
     */
    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }

    /**
     * Set Attributes Main Gallery product.
     */
    public function setMainGalleryAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['main_gallery'] = json_encode($images);
        }
    }

    /**
     * Get Main Gallery for the product.
     */
    public function getMainGalleryAttribute($images)
    {
        return json_decode($images, true);
    }

    /**
     * Get prices for the product.
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    /**
     * Get Related products for the product.
     */
    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class);
    }

    /**
     * Get Related products for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get related products Ids for the product.
     *
     * @var $value
     * @return array
     */
    public function getRelatedAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Set related products Ids for the product.
     *
     * @var $value
     */
    public function setRelatedAttribute($value)
    {
        $this->attributes['related'] = implode(',', $value);
    }
}
