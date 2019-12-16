<?php

/** @var Factory $factory */

use App\Models\ProductAttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProductAttributeValue::class, function (Faker $faker) {
    return [
        'attribute_value_id'    => $faker->numberBetween( 1, \App\Models\AttributeValue::all()->count() ),
        'stock'           => $faker->numberBetween( 20, 200 ),
        'sku'            => $faker->word . '_' . $faker->numberBetween( 1000, 9999 ),
    ];
});
