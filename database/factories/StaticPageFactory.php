<?php

/** @var Factory $factory */

use App\Models\StaticPage;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$fakerAR = \Faker\Factory::create( 'ar_SA' );

$factory->define( StaticPage::class, function ( Faker $faker ) use ($fakerAR) {

    return [
        'type'     => $faker->randomElement( ['about_us', 'contact_us', 'privacy', 'terms', 'news'] ),
        'title_en' => $faker->sentence(4),
        'title_ar' => $fakerAR->sentence(4),
        'body_en'  => $faker->text,
        'body_ar'  => $fakerAR->text,
        'slug'     => $faker->slug,
        'banner'   => $faker->imageUrl( 1274, 241 ),
    ];
} );
