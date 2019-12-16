<?php

/** @var Factory $factory */

use App\Models\ProductAttributeValueImage;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( ProductAttributeValueImage::class, function ( Faker $faker ) {
    return [
        'image'                      => $faker->imageUrl( 300, 300 ),
    ];
} );
