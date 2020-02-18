<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/***************************************************************************************************
 * â–‚ â–ƒ â–… â–† â–ˆ  Home Sections â–ˆ â–† â–… â–ƒ â–‚
 ***************************************************************************************************/
Route::group(['prefix'=>'v1', "namespace"=>"HomeSections"], function(){
    // Controllers Within The "App\Http\Controllers\HomeSections" Namespace
    Route::get('home-sliders','SliderController@homeSlides');
    Route::get('home-arrivals','NewArrivalController@homeNewArrivals');
    Route::get('home-offers','OfferController@homeOffers');
    Route::get('home-best-sellers','BestSellerController@homeBestSeller');
});

/***************************************************************************************************
 * â–‚ â–ƒ â–… â–† â–ˆ  Admin Statistics  â–ˆ â–† â–… â–ƒ â–‚
 ***************************************************************************************************/
Route::group(['prefix'=>'v1'], function(){
    Route::get('/admin/statistics/sales/{month}', '\App\Admin\Controllers\HomeController@totalSales');
    Route::get('/admin/statistics/orders/{month}', '\App\Admin\Controllers\HomeController@totalOrders');
});

/***************************************************************************************************
 * â–‚ â–ƒ â–… â–† â–ˆ  Authentication  â–ˆ â–† â–… â–ƒ â–‚
 ***************************************************************************************************/
Route::group(['prefix'=>'v1'], function(){
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('register/corporate', 'AuthController@registerCorporate');
});

Route::group(['prefix'=>'v1'], function(){

    Route::get('home-categories','CategoryController@homeCategories');
    Route::get('products-best-list','BestSellerController@bestSeller');
    Route::get('category-products/{slug}','CategoryController@categoryProducts');
    Route::get('filter-categories/{slug?}','CategoryController@listFilterCategories');
    Route::get('filter-colors','AttributeController@listFilterColors');
    Route::get('products/{slug}','ProductController@productDetails');
    Route::get('search/{term}','ProductController@searchProducts');
    Route::get('settings','SettingController@getSettings');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::post('cart/item','CartController@storeItem');
        Route::post('cart/item/edit','CartController@updateItem');
        Route::post('cart/item/remove','CartController@removeItem');
        Route::post('order','OrderController@store');
        Route::get('receipt/{code}','OrderController@getUserReceipt');

        Route::get('products/{slug}/prices','ProductController@productPrices');
        Route::get('user/reviews-list','UserController@userReviews');
        Route::get('user-ability/review/{id}','UserController@userAbleToReview');
        Route::post('/user/review','UserController@reviewStore');

        Route::get('account/orders','OrderController@getUserOrders');
        Route::get('account/orders/{id}','OrderController@getUserOrderDetails');
        Route::get('account/wishlist','UserController@accountWishlist');
        Route::get('account/info','UserController@accountInfo');
        Route::post('account/info','UserController@updateAccountInfo');
        Route::post('account/reorder','OrderController@tryToReorder');

    });
});
