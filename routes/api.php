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

    Route::get('home-categories','CategoryController@homeCategories');
    Route::get('home-sliders','SliderController@homeSlides');
    Route::get('home-arrivals','NewArrivalController@homeNewArrivals');
    Route::get('home-offers','OfferController@homeOffers');
    Route::get('home-best-sellers','BestSellerController@homeBestSeller');
    Route::get('category-products/{slug}','CategoryController@categoryProducts');

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});
