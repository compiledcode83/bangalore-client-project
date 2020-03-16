<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
//    $router->get('/', 'HomeController@homeStatus')->name('admin.home');


    $router->resource('categories', CategoryController::class);
    $router->resource('users', UserController::class);
    $router->resource('corporates', CorporateController::class);
    $router->resource('pending-corporates', PendingCorporateController::class);

    $router->resource('products', ProductController::class);
    $router->resource('product-attribute-values', ProductAttributeImagesController::class);

    $router->resource('statuses', StatusController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('sliders', SliderController::class);
    $router->resource('static-pages', StaticPageController::class);

    $router->resource('settings', SettingController::class);
    $router->get('/settings-update/{id}', 'SettingController@updateSettings')->name('admin.updateSettings');

    $router->resource('reviews', ReviewController::class);

    $router->resource('homepage-sections-arrival', HomeNewArrivalController::class);
    $router->resource('homepage-sections-offers', HomeSpecialOfferController::class);

    $router->resource('media', MediaController::class);
    $router->resource('service', ServiceController::class);
    $router->resource('faq', FaqController::class);
    $router->resource('clientlogo', ClientLogoController::class);
    $router->resource('subsidiarie', SubsidiarieController::class);

    $router->resource('attribute-values', ColorController::class);

    $router->resource('governorates', GovernorateController::class);
    $router->resource('areas', AreaController::class);
    $router->resource('delivery-charges', CoverageAreaController::class);

    $router->get('/newsletter', 'NewsLetterController@index')->name('admin.newsletter');
    $router->post('/newsletter/send', 'NewsLetterController@sendMails')->name('admin.newsletter.send');

    $router->get('/excel', 'ImportExcelController@import')->name('admin.import.products');
    $router->post('/excel/store', 'ImportExcelController@store')->name('admin.import.products.store');

    $router->get('/excel/images', 'ImportExcelController@uploadImages')->name('admin.import.images');
    $router->post('/excel/images/store', 'ImportExcelController@storeImages')->name('admin.import.images.store');

    $router->resource('/reports/sales', 'Reports\SalesReportController');
    $router->resource('/reports/orders', 'Reports\OrdersReportController');
    $router->resource('/reports/delivery', 'Reports\DeliveryReportController');
    $router->resource('/reports/products', 'Reports\ProductsReportController');
    $router->resource('/reports/users', 'Reports\UsersReportController');

    $router->post('/order/update-details', 'OrderController@updateDetails')->name('admin.order.updateDetails');

    $router->resource('social-media', SocialMediaController::class);

});
