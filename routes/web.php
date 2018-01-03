<?php

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

Route::group(['middleware' => ['web']], function () {

	Route::get('/', 'ProductController@index');

	Route::get('/product/{product_id}/variant/{variant_id}', 'ProductController@editVariant')->name('variant.edit');
	Route::put('/variant/update/{id}', 'ProductController@updateVariant')->name('variant.update');

	Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
	Route::put('/product/update/{id}', 'ProductController@update')->name('product.update');

	Route::get('/product/create', 'ProductController@create')->name('product.create');
	Route::post('/product/store', 'ProductController@store')->name('product.store');
	Route::get('/product/destroy/{id}', 'ProductController@destroy')->name('product.destroy');
	Route::post('/product/{product_id}/variant/destroy/{variant_id}', 'ProductController@variantDestroy')->name('variant.destroy');
});