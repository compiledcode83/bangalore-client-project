<?php

/** @var Factory $factory */

use App\Models\OrderStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderStatus::class, function (Faker $faker) {
    return [
        'order_id'    => $faker->numberBetween( 1, 4 ),
        'status_id'    => $faker->numberBetween( 1, 5 ),
        'comment'    => $faker->realText(50)
    ];
});
