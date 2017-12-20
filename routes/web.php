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

Auth::routes();

Route::resource('/', 'ProductController');

Route::get('/', 'ProductController@index');

Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::put('/product/update/{id}', 'ProductController@update')->name('product.update');

Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::post('/product/store', 'ProductController@store')->name('product.store');

Route::get('/tags/find', 'ProductController@findTag');

Route::post('/product/destroy', 'ProductController@destroy')->name('product.destroy');