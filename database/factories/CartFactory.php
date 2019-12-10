<?php

/** @var Factory $factory */

use App\Models\Cart;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Cart::class, function (Faker $faker) {

    $total = $faker->randomFloat(NULL, 2, 500);
    return [
        'session_id' => str_random(20),
        'total' => $total,
        'discount' => 0,
        'subtotal' => $total,
    ];
});
