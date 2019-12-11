<?php

/** @var Factory $factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( OrderItem::class, function ( Faker $faker ) {
    return [
        'order_id'                   => $faker->numberBetween( 1, 4 ),
        'product_attribute_value_id' => $faker->numberBetween( 1, 10 ),
        'unit_price'                 => $faker->numberBetween( 10, 50 ),
        'qty'                        => $faker->numberBetween( 1, 3 ),
    ];
} );
