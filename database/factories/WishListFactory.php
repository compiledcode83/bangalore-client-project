<?php

/** @var Factory $factory */

use App\Models\Wishlist;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( WishList::class, function ( Faker $faker ) {
    return [
        'user_id'    => $faker->numberBetween( 1, 20 ),
        'product_id' => $faker->numberBetween( 1, 10 ),
        'qty'        => $faker->numberBetween( 1, 5 ),
    ];
} );
