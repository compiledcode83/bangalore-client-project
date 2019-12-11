<?php

/** @var Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Order::class, function ( Faker $faker ) {
    return [
        'user_id'    => $faker->numberBetween( 1, 10 ),
        'order_code' => $faker->word . '_' . $faker->numberBetween( 1000, 9999 ),
        'address'    => $faker->address,
        'total'      => $faker->numberBetween( 20, 200 ),
    ];
} );
