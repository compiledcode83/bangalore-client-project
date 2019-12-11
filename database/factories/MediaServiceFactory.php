<?php

/** @var Factory $factory */

use App\Models\MediaService;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(MediaService::class, function ( Faker $faker) {

    $title = $faker->title;
    return [
        'title_en' => $title,
        'title_ar' => $title,
        'short_description_en' => $faker->text,
        'short_description_ar' => $faker->text,
        'full_description_en' => $faker->text,
        'full_description_ar' => $faker->text,
        'image' => $faker->imageUrl(1274, 241),
    ];
});
