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
    Route::get('/product/{id}', 'ProductController@show');
    Route::get('/banner/', 'BannerController@index');
    Route::get('/category','CategoryController@index');
    Route::post('/couponcode','OrderController@ChangeCoupon');
    //ReportUser
    Route::get('reportuser','ReportController@index');
    Route::post('/reportusers/{id}','ReportController@show');

    Route::middleware('api.auth')->group(function() {
        //Auth
        Route::post('me','AuthController@me');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout','AuthController@logout');

        //Route::resource('/cart', 'carttController')->except('create', 'edit','show');

        //Banner
        Route::post('/bannerimg','BannerController@upladImg');
        Route::put('banner/{id}','BannerController@update');
        Route::resource('banner','BannerController')->except('create','edit','index','update');

        //order
        Route::patch('orders/{order}/deliver','OrderController@deliverOrder');
        Route::resource('order','OrderController')->except('create','edit');

        //Category
        Route::resource('category','CategoryController')->except('create','edit')->except('index');

        //Counpon
        Route::resource('coupon','CouponController')->except('create','edit');

        //report
        Route::post('reportuser/{id}','ReportController@store');



        //products
        Route::post('product/{id}','ProductController@update');
        Route::post('/upload', 'ProductController@uploadFile');
        Route::resource('product','ProductController')->except('create','edit','index','show');

        //image
        Route::post('/deletemultipleimg','ImageController@deleteImg');
        //User
        Route::patch('user/{user}/accept','UserController@acceptUser');
        Route::get('/user/{user}/order','UserController@OrderUser');
        Route::resource('user','UserController')->except('create','edit');

     });

    Route::get('product','ProductController@index');

    Route::post('login', 'AuthController@login');
    Route::post('register','AuthController@register');
    Route::post('addimg/{id}','ProductController@addMoreImgToProduct');
});
