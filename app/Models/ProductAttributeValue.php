<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValue extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at'];

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

//    public function attributeImages()
//    {
//        return $this->hasMany(ProductAttributeValueImage::class);
//    }

    public function setAsdPicturesAttribute($collection)
    {

        if (is_array($collection)) {
            $this->attributes['asd_pictures'] = json_encode($collection);
        }
    }

    public function getAsdPicturesAttribute($collection)
    {
        return json_decode($collection, true) ?: [];
    }

    public function setMainImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['main_images'] = json_encode($images);
        }
    }

    public function getMainImagesAttribute($images)
    {
        return json_decode($images, true);
    }
}
