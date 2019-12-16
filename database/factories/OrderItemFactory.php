<?php

/** @var Factory $factory */

use App\Models\OrderItem;
use App\Models\ProductAttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( OrderItem::class, function ( Faker $faker ) {
    return [
        'product_attribute_value_id' => $faker->numberBetween( 1, ProductAttributeValue::all()->count() ),
        'unit_price'                 => $faker->numberBetween( 10, 50 ),
        'qty'                        => $faker->numberBetween( 1, 3 ),
    ];
} );
