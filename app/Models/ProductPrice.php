<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getUserPriceAttribute()
    {
        if($this->individual_discounted_unit_price > 0){
            return $this->individual_discounted_unit_price;
        }else{
            return $this->individual_unit_price;
        }
    }

    public function getCorporatePriceAttribute()
    {
        if($this->corporate_discounted_unit_price > 0){
            return $this->corporate_discounted_unit_price;
        }else{
            return $this->corporate_unit_price;
        }
    }
}
