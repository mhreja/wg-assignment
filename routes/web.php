<?php

use Illuminate\Support\Facades\Route;



Route::get('/', 'UserController@index')->name('user.index');
Route::get('/get/users', 'UserController@getusers')->name('user.getusers');
Route::post('/store/user', 'UserController@store')->name('user.store');
Route::put('/edit/{user}/user', 'UserController@update')->name('user.update');
Route::delete('/delete/{user}/user', 'UserController@delete')->name('user.delete');


Route::get('/products', 'ProductController@index')->name('product.index');
Route::get('/get/products', 'ProductController@getproducts')->name('product.getproducts');
Route::post('/products/filter-by-date', 'ProductController@filterbydate')->name('product.filterbydate');
Route::post('/store/product', 'ProductController@store')->name('product.store');
Route::post('/edit/{product}/product', 'ProductController@update')->name('product.update');
Route::get('/delete/{product}/product', 'ProductController@delete')->name('product.delete');


//MyDataTable
Route::get('/MyDataTable', 'MyDatatableController@index')->name('mydatatable.index');
Route::get('/MyDataTable/get/users/new', 'MyDatatableController@newgetusers')->name('user.newgetusers');

//AWS S3 bucket Upload
Route::get('aws/up', 'ImageController@index')->name('aws.index');
Route::post('aws/up', 'ImageController@store')->name('aws.store');

//Testing
Route::get('test', 'TestController@index');