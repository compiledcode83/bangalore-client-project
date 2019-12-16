<?php

/** @var Factory $factory */

use App\Models\ProductMainImage;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( ProductMainImage::class, function ( Faker $faker ) {
    return [
        'product_id' => $faker->numberBetween( 1, 20 ),
        'image'      => $faker->imageUrl( 300, 300 ),
    ];
} );
