<?php

/** @var Factory $factory */

use App\Models\Review;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Review::class, function ( Faker $faker ) {
    return [
        'user_id'    => $faker->numberBetween( 1, \App\Models\User::all()->count() ),
        'product_id' => $faker->numberBetween( 1, \App\Models\Product::all()->count() ),
        'order_id'   => $faker->numberBetween( 1, \App\Models\Order::all()->count() ),
        'rating'     => $faker->numberBetween( 1, 5 ),
        'review'     => $faker->realText( 100 ),
    ];
} );
