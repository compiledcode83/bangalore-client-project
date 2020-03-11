<?php

namespace App\Models;

use App\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, LocaleTrait;

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at'];

    /**
     * The attributes that should be mutated locale.
     * @var array
     */
    protected $localeStrings = ['name'];

    /**
     * The attributes that must be protected from mass assignment.
     * @var array
     */
    protected $guarded = ['id'];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $slug = str_slug($model->name_en);
            $count = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    /**
     * Scope a query to only include root Categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeRootParent($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Scope a query to only include children Categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeChildren($query)
    {
        return $query->where('parent_id', '!=',  0);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
