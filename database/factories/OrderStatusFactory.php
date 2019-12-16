<?php

/** @var Factory $factory */

use App\Models\OrderStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderStatus::class, function (Faker $faker) {
    return [
        'status_id'    => $faker->numberBetween( 1, OrderStatus::all()->count() ),
        'comment'    => $faker->realText(50)
    ];
});
