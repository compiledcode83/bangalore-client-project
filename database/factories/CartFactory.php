<?php

/** @var Factory $factory */

use App\Models\Cart;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Cart::class, function ( Faker $faker ) {

    $total = $faker->randomFloat( null, 2, 500 );

    return [
        'user_id'    => $faker->numberBetween( 1, \App\Models\User::all()->count() ),
        'session_id' => str_random( 20 ),
        'total'      => $total,
        'discount'   => 0,
        'subtotal'   => $total,
    ];
} );
