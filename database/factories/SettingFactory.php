<?php

/** @var Factory $factory */

use App\Models\Setting;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( Setting::class, function ( Faker $faker ) {
    return [
        'contact_us_banner'     => $faker->imageUrl( 1274, 241 ),
        'faq_banner'            => $faker->imageUrl( 1274, 241 ),
        'sitemap_banner'        => $faker->imageUrl( 1274, 241 ),
        'media_banner'          => $faker->imageUrl( 1274, 241 ),
        'services_banner'       => $faker->imageUrl( 1274, 241 ),
        'special_offers_banner' => $faker->imageUrl( 1274, 241 ),

    ];
} );
