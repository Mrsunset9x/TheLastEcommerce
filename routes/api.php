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
    Route::middleware('api.auth')->group(function() {
        //Auth
        Route::post('me','AuthController@me');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout','AuthController@logout');

        //Route::resource('/cart', 'carttController')->except('create', 'edit','show');

        //Banner
        Route::post('banner/{id}','BannerController@update');
        Route::resource('banner','BannerController')->except('create','edit');

        //order
        Route::patch('orders/{order}/deliver','OrderController@deliverOrder');
        Route::resource('order','OrderController')->except('create','edit');

        //Category
        Route::resource('category','CategoryController')->except('create','edit');

        //Counpon
        Route::resource('coupon','CouponController')->except('create','edit');

        //products
        Route::post('product/{id}','ProductController@update');
        Route::post('/upload', 'ProductController@uploadFile');
        Route::resource('product','ProductController')->except('create','edit','index');
        Route::post('addimg/{id}','ProductController@addMoreImgToProduct');

        //User
        Route::patch('user/{user}/accept','UserController@acceptUser');
        Route::resource('user','UserController')->except('create','edit');

     });
    Route::get('product','ProductController@index');

    Route::post('login', 'AuthController@login');
    Route::post('register','AuthController@register');
});
