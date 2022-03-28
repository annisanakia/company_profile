<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|n
*/

Route::group(['prefix' => 'product_category', 'namespace' => 'App\Modules\Product_category\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'product_category.index', 'uses' => 'Product_category@index']);
    Route::post('/store', ['as' => 'product_category.store', 'uses' => 'Product_category@store']);
    Route::get('/edit/{id}', ['as' => 'product_category.edit', 'uses' => 'Product_category@edit']);
    Route::get('/detail/{id}', ['as' => 'product_category.detail', 'uses' => 'Product_category@detail']);
    Route::patch('/update/{id}', ['as' => 'product_category.update', 'uses' => 'Product_category@update']);
    Route::get('/delete/{id}', ['as' => 'product_category.delete', 'uses' => 'Product_category@delete']);
    Route::get('/create', ['as' => 'product_category.create', 'uses' => 'Product_category@create']);
    Route::post('/', ['as' => 'product_category.search', 'uses' => 'Product_category@index']);
    Route::post('/delete_row', ['as' => 'product_category.delete_row', 'uses' => 'Product_category@delete_row']);
});