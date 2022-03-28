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

Route::group(['prefix' => 'article', 'namespace' => 'App\Modules\Article\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'article.index', 'uses' => 'Article@index']);
    Route::post('/store', ['as' => 'article.store', 'uses' => 'Article@store']);
    Route::get('/edit/{id}', ['as' => 'article.edit', 'uses' => 'Article@edit']);
    Route::get('/detail/{id}', ['as' => 'article.detail', 'uses' => 'Article@detail']);
    Route::patch('/update/{id}', ['as' => 'article.update', 'uses' => 'Article@update']);
    Route::get('/delete/{id}', ['as' => 'article.delete', 'uses' => 'Article@delete']);
    Route::get('/create', ['as' => 'article.create', 'uses' => 'Article@create']);
    Route::post('/', ['as' => 'article.search', 'uses' => 'Article@index']);
    Route::post('/delete_row', ['as' => 'article.delete_row', 'uses' => 'Article@delete_row']);
});