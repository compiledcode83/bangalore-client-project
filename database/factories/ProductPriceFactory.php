<?php

/** @var Factory $factory */

use App\Models\ProductPrice;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( ProductPrice::class, function ( Faker $faker ) {
    return [
        'product_id'                       => $faker->numberBetween( 1, 10 ),
        'max_qty'                          => $faker->numberBetween( 1, 5 ),
        'individual_unit_price'            => $faker->numberBetween( 50, 100 ),
        'corporate_unit_price'             => $faker->numberBetween( 100, 200 ),
        'individual_discounted_unit_price' => $faker->numberBetween( 10, 50 ),
        'corporate_discounted_unit_price'  => $faker->numberBetween( 50, 100 ),
    ];
} );
