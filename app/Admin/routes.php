<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('categories', CategoryController::class);
    $router->resource('users', UserController::class);

    $router->resource('products', ProductController::class);
    $router->resource('product-attribute-values', ProductAttributeImagesController::class);

    $router->resource('statuses', StatusController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('sliders', SliderController::class);
    $router->resource('static-pages', StaticPageController::class);
    $router->resource('settings', SettingController::class);
    $router->resource('reviews', ReviewController::class);

    $router->resource('homepage-sections-arrival', HomeNewArrivalController::class);
    $router->resource('homepage-sections-offers', HomeSpecialOfferController::class);

    $router->resource('media', MediaController::class);
    $router->resource('service', ServiceController::class);

});
