<?php

/** @var Factory $factory */

use App\Models\AttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(AttributeValue::class, function (Faker $faker) {

    $value = $faker->name;

    return [
        'value_en' => $value,
        'value_ar' => $value,
    ];
});
