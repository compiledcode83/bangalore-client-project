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
    Route::get('cart/restore','CartController@restoreCart');
});

Route::group(['prefix'=>'v1'], function(){

    Route::get('home-categories','CategoryController@homeCategories');
    Route::get('products-best-list','HomeSections\BestSellerController@bestSeller');
    Route::get('category-products/{slug}','CategoryController@categoryProducts');
    Route::get('offers','ProductController@onlyOffers');
    Route::get('filter-categories/{slug?}','CategoryController@listFilterCategories');
    Route::get('filter-colors','AttributeController@listFilterColors');
    Route::get('products/{slug}','ProductController@productDetails');
    Route::get('search/{term}','ProductController@searchProducts');
    Route::get('settings','SettingController@getSettings');
    Route::get('static/about','AboutController@getInformations');
    Route::get('static/contact','ContactController@getInformations');
    Route::post('static/contact','ContactController@sentMail');
    Route::get('static/media','MediaServiceController@getMedias');
    Route::get('static/service','MediaServiceController@getServices');
    Route::get('static/page/{slug}','PageController@getPage');
    Route::get('social','PageController@getSocial');

    // Send reset password mail
    Route::post('reset-password', 'AuthController@sendPasswordResetLink');
    // handle reset password form process
    Route::post('reset/password', 'AuthController@callResetPassword');

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

        Route::get('account/checkout/addresses','AddressesController@getUserAddressesForCheckout');
        Route::get('account/addresses','AddressesController@getUserAddresses');
        Route::post('account/addresses/new','AddressesController@store');
        Route::post('account/addresses/delete','AddressesController@deleteAddress');
        Route::get('account/newsletter','NewsletterController@getUserSubscription');
        Route::post('account/newsletter','NewsletterController@updateSubscription');
        Route::post('email/newsletter','NewsletterController@updateSubscriptionByEmail');
        Route::get('account/orders','OrderController@getUserOrders');
        Route::get('account/orders/{id}','OrderController@getUserOrderDetails');
        Route::get('account/order/{id}/status','OrderController@getUserOrderStatuses');
        Route::get('account/wishlist','UserController@accountWishlist');
        Route::post('account/wishlist','UserController@storeAccountWishlist');
        Route::post('account/wishlist/attribute','UserController@storeAccountWishlistFromAttribute');
        Route::get('account/wishlist/remove/{id}','UserController@accountRemoveWishlistItem');
        Route::get('account/info','UserController@accountInfo');
        Route::post('account/info','UserController@updateAccountInfo');
        Route::post('account/reorder','OrderController@tryToReorder');

        Route::post('checkout/delivery-charges','AddressesController@getDeliveryChargesForAddress');


    });
});
