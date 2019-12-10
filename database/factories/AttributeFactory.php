<?php

/** @var Factory $factory */

use App\Models\Attribute;
use App\Models\AttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Attribute::class, function (Faker $faker) {

    $name = $faker->name;
    return [
        'name_en' => $name,
        'name_ar' => $name,
    ];
});

$factory->afterCreating(Attribute::class, function ($attribute, $faker) {
    $attribute->attributeValues()->saveMany(factory( AttributeValue::class, 3)->make());
});
