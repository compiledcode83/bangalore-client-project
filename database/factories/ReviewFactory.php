<?php

/** @var Factory $factory */

use App\Models\Review;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Review::class, function ( Faker $faker ) {
    return [
        'user_id'    => $faker->numberBetween( 1, 20 ),
        'product_id' => $faker->numberBetween( 1, 10 ),
        'order_id'   => $faker->numberBetween( 1, 5 ),
        'rating'     => $faker->numberBetween( 1, 5 ),
        'review'     => $faker->realText( 100 ),
    ];
} );
