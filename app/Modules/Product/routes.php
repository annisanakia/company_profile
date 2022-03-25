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

Route::group(['prefix' => 'product', 'namespace' => 'App\Modules\Product\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'product.index', 'uses' => 'Product@index']);
    Route::post('/store', ['as' => 'product.store', 'uses' => 'Product@store']);
    Route::get('/edit/{id}', ['as' => 'product.edit', 'uses' => 'Product@edit']);
    Route::get('/detail/{id}', ['as' => 'product.detail', 'uses' => 'Product@detail']);
    Route::patch('/update/{id}', ['as' => 'product.update', 'uses' => 'Product@update']);
    Route::get('/delete/{id}', ['as' => 'product.delete', 'uses' => 'Product@delete']);
    Route::get('/create', ['as' => 'product.create', 'uses' => 'Product@create']);
    Route::post('/', ['as' => 'product.search', 'uses' => 'Product@index']);
    Route::post('/delete_row', ['as' => 'product.delete_row', 'uses' => 'Product@delete_row']);
});