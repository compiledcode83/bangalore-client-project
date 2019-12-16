<?php

/** @var Factory $factory */

use App\Models\RelatedProduct;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( RelatedProduct::class, function ( Faker $faker ) {

    return [
        'related_product_id' => $faker->numberBetween( 1, \App\Models\Product::all()->count() ),
    ];
} );
