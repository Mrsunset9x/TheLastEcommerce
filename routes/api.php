<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('api')->prefix('v1')->group(function(){
    // Route::middleware('api.auth')->group(function() {

        Route::post('me','AuthController@me');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout','AuthController@logout');

        //Route::resource('/cart', 'carttController')->except('create', 'edit','show');

        Route::post('banner/{id}','BannerController@update');
        Route::resource('banner','BannerController')->except('create','edit');
        Route::resource('order','OrderController')->except('create','edit');
        Route::resource('category','CategoryController')->except('create','edit');
        Route::resource('coupon','CouponController')->except('create','edit');
        Route::post('product/{id}','ProductController@update');
        Route::resource('product','ProductController')->except('create','edit');
        Route::post('addimg/{id}','ProductController@addMoreImgToProduct');
    // });

    Route::post('login', 'AuthController@login');
    Route::post('register','AuthController@register');
});
