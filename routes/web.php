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

Route::get('/', function () {
   return view('home.index');
});

Route::get('/admin','Api\AdminController@login');
Route::post('/postLogin','Api\AdminController@postLogin');

Route::get('/adminapi', function(){
    return view('admin.index');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
