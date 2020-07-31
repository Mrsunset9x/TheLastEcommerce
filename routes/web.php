<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/cart/{id}','Api\CartController@addProductToCart')->name('cartt');
Route::get('/cart','Api\CartController@getAll');
Route::middleware('api.auth')->group(function() {
    Route::resource('/cart', 'Api\CartController')->except('index');
});

Route::get('/{any}', function(){
        return view('landing');
})->where('any', '.*')->name('home');
