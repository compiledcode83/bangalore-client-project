<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedProduct extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'product_id'];

    //To be deleted
//    public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }
}
