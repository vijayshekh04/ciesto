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

/*Route::get('/', function () {
    return view('product.index');
});*/

//shop
Route::post('shop/destroy','ShopController@destroy');
Route::match(['post'],'shop/datatable',"ShopController@datatable");
Route::resource('shop',"ShopController");


//Product
Route::post('product/destroy','ProductController@destroy');
Route::match(['post'],'product/datatable',"ProductController@datatable");
Route::resource('product',"ProductController");
