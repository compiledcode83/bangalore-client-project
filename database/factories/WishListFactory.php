<?php

/** @var Factory $factory */

use App\Models\Wishlist;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( WishList::class, function ( Faker $faker ) {
    return [
        'product_id' => $faker->numberBetween( 1, \App\Models\Product::all()->count() ),
        'qty'        => $faker->numberBetween( 1, 5 ),
    ];
} );
