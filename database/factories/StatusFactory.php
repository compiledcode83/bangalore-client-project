<?php

/** @var Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Status::class, function (Faker $faker) {

    $title = $faker->realText(50);
    return [
        'name_en'   => $title,
        'name_ar'   => $title,
    ];
});
