<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaService extends Model
{
    use SoftDeletes;

    const TYPE_MEDIA = 1;
    const TYPE_SERVICE = 2;

    protected $guarded = ['id'];

    /**
     * Scope a query to only include Services or Media.
     *
     * @param  Builder  $query
     * @param  mixed  $type
     * @return Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
