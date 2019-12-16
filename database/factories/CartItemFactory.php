<?php

/** @var Factory $factory */

use App\Models\CartItem;
use App\Models\ProductAttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(CartItem::class, function (Faker $faker) {
    return [
        'product_attribute_value_id' => $faker->numberBetween( 1, ProductAttributeValue::all()->count() ),
    ];
});
