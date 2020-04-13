<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
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

    public function search($term)
    {
        //save meaningless search with 1 or 2 characters
        if(strlen($term) < 3)
        {
            return [];
        }
        $products = Self::where('name_en', 'like', "%".$term."%")
                        ->orWhere('name_ar', 'like', "%".$term."%")
                        ->orWhere('sku', 'like', "%".$term."%")
                        ->orderBy('created_at', 'desc')
                        ->active()
                        ->get();

        return $products;
    }

    public function getProductsRatingColors($products)
    {
        foreach ($products as $product)
        {
            //add ratings
            if ( $product->reviews->first() )
            {
                $reviews = $product->reviews;
                $count = $reviews->count();
                if ( $count )
                {
                    $product->rating = ceil( $reviews->sum( 'rating' ) / $count );
                }
            }
            //add colors and ,'new' status
            $colors = [];
            if($product->productAttributeValues->first())
            {
                foreach ($product->productAttributeValues as $productAttributeValue)
                {
                    if(isset($productAttributeValue->attributeValue->other_value))
                    {
                        $colors [] = $productAttributeValue->attributeValue->other_value;
                    }
                }

            }
            $product->colors = $colors;

            if($product->created_at >= Carbon::now()->subDays(14)->toDateTimeString())
            {
                $product->newIcon = true;
            }

        }

        return $products;
    }

    public function getProductsFilterAttributes($products)
    {
        $colors = [];
        $categories = [];
        $prices = [];
        $discounts = [];
        foreach ($products as $product)
        {
            // get colors
            if($product->productAttributeValues->first())
            {
                foreach ($product->productAttributeValues as $productAttributeValue)
                {
                    if(isset($productAttributeValue->attributeValue->other_value))
                    {
                        $colors [] = [
                            'id' => $productAttributeValue->attributeValue->id,
                            'other_value' => $productAttributeValue->attributeValue->other_value
                            ];
                    }
                }

            }
            // get Categories
            if($product->categories->first())
            {
                foreach ($product->categories as $category)
                {
                    $categories [] = $category->name_en;
                }
            }

            $user = Auth::guard('api')->user();

            if($user)
            {
                // get prices
                if($product->prices->first())
                {
                    foreach ($product->prices as $price)
                    {
                        if ( $user->type == User::TYPE_USER )
                        {
                            $prices [] = $price->individual_unit_price;
                            // (unitPrice - discounted) / unitPrice * 100
                            if($price->individual_discounted_unit_price && $price->individual_discounted_unit_price != '0')
                            {
                                $discounts [] = (($price->individual_unit_price - $price->individual_discounted_unit_price) / $price->individual_unit_price) * 100;
                            }
                        }

                        if ( $user->type == User::TYPE_CORPORATE )
                        {
                            $prices [] = $price->corporate_unit_price;
                            // (unitPrice - discounted) / unitPrice * 100
                            if($price->corporate_discounted_unit_price && $price->corporate_discounted_unit_price != '0')
                            {
                                $discounts [] = (($price->corporate_unit_price - $price->corporate_discounted_unit_price) / $price->corporate_unit_price) * 100;
                            }
                        }
                    }

                }
            }


        }

        $colors = $this->unique_multidim_array($colors,'other_value');
        $categories = array_unique($categories);
        $prices = array_unique($prices);
        $priceMin = count($prices) > 0 ? min($prices) : 0;
        $priceMax = count($prices) > 0 ? max($prices) : 0;
        $discounts = array_unique($discounts);
        foreach ($discounts as $discount)
        {
            if($discount <= 30)
            {
                $discounts['filter']['upTo30'] = '30';
            }
            if($discount > 30 && $discount <= 50)
            {
                $discounts['filter']['upTo50'] = '49';
            }
            if($discount > 50 && $discount <= 60)
            {
                $discounts['filter']['upTo60'] = '59';
            }
            if($discount >= 60)
            {
                $discounts['filter']['moreThan60'] = '60';
            }
        }
        if(isset($discounts['filter']))
        {
            $discounts['filter'] = array_unique($discounts['filter']);
        }

        return [
            'colors'        => $colors,
            'categories'    => $categories,
            'discounts'    => $discounts,
            'prices'        => [
                'all'   => $prices,
                'min'   => $priceMin,
                'max'   => $priceMax
            ]
        ];
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
