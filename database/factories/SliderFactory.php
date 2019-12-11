<?php

/** @var Factory $factory */


use App\Models\Slider;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Slider::class, function ( Faker $faker) {
    return [
        'order' => $faker->randomDigit,
        'image' => $faker->imageUrl(1274, 241),
        'link' => $faker->imageUrl(1274, 241),
    ];
});
