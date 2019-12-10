<?php

/** @var Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->name;
    $description = $faker->text;
    return [
        'parent_id'     => 0,
        'name_en'       => $name,
        'name_ar'       => $name,
        'description_en'=> $description,
        'description_ar'=> $description,
        'slug'          => $faker->slug,
        'banner'        => $faker->imageUrl(1274, 241),
        'image'         => $faker->imageUrl(1274, 241),
    ];
});
