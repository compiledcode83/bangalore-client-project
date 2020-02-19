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


Route::group(['prefix'=>'v1'], function(){

    //admin statistics
    Route::get('/admin/statistics/sales/{month}', '\App\Admin\Controllers\HomeController@totalSales');
    Route::get('/admin/statistics/orders/{month}', '\App\Admin\Controllers\HomeController@totalOrders');

    Route::get('home-categories','CategoryController@homeCategories');
    Route::get('home-sliders','SliderController@homeSlides');
    Route::get('home-arrivals','NewArrivalController@homeNewArrivals');
    Route::get('home-offers','OfferController@homeOffers');
    Route::get('home-best-sellers','BestSellerController@homeBestSeller');
    Route::get('products-best-list','BestSellerController@bestSeller');
    Route::get('category-products/{slug}','CategoryController@categoryProducts');
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

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('register/corporate', 'AuthController@registerCorporate');

    Route::get('auth',function(){
        Auth::loginUsingId(3, true);
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::post('cart/item','CartController@storeItem');
        Route::post('cart/item/edit','CartController@updateItem');
        Route::post('order','OrderController@store');
        Route::get('receipt/{code}','OrderController@getUserReceipt');

        Route::get('products/{slug}/prices','ProductController@productPrices');
        Route::get('user/reviews-list','UserController@userReviews');
        Route::get('user-ability/review/{id}','UserController@userAbleToReview');
        Route::post('/user/review','UserController@reviewStore');

        Route::get('account/wishlist','UserController@accountWishlist');
        Route::get('account/info','UserController@accountInfo');
        Route::post('account/info','UserController@updateAccountInfo');

    });
});
