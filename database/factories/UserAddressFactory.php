<?php

/** @var Factory $factory */

use App\Models\UserAddress;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( UserAddress::class, function ( Faker $faker ) {
    return [
        'user_id'   => $faker->numberBetween( 1, 35 ),
        'country'   => $faker->country,
        'city'      => $faker->city,
        'area'      => $faker->city,
        'block'     => $faker->word,
        'street'    => $faker->state,
        'avenue'    => $faker->word,
        'building'  => $faker->numberBetween( 1, 20 ),
        'floor'     => $faker->numberBetween( 1, 20 ),
        'apartment' => $faker->numberBetween( 1, 20 ),
    ];
} );
