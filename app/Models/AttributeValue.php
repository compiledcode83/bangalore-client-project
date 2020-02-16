<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model {

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


    /**
     * Get the attribute values for the attribute.
     */
    public function productAttributeValues()
    {
        return $this->hasMany( ProductAttributeValue::class, 'attribute_value_id' );
    }

    /**
     * Get the attribute owns value
     */
    public function attribute()
    {
        return $this->belongsTo( Attribute::class );
    }

    public static function options( $id = null )
    {
        if ( !$id )
        {
            return self::all()->pluck( 'value_en', 'id' );
        }
        if ( !$self = static::find( $id ) )
        {
            return [];
        }

        return $self->pluck( 'value_en', 'id' );
    }
}
