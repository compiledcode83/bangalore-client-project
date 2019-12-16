<?php

/** @var Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Product::class, function ( Faker $faker ) {

    $name = $faker->sentence( 2);

    return [
        'name_en'        => $name,
        'name_ar'        => $name,
        'description_en' => $faker->text,
        'description_ar' => $faker->text,
        'slug'           => $faker->slug,
        'sku'            => $faker->word . '_' . $faker->numberBetween( 1000, 9999 ),
        'main_image'     => $faker->imageUrl( 300, 300 ),
    ];
} );
