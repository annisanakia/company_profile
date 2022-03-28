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

Route::group(['prefix' => 'article_category', 'namespace' => 'App\Modules\Article_category\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'article_category.index', 'uses' => 'Article_category@index']);
    Route::post('/store', ['as' => 'article_category.store', 'uses' => 'Article_category@store']);
    Route::get('/edit/{id}', ['as' => 'article_category.edit', 'uses' => 'Article_category@edit']);
    Route::get('/detail/{id}', ['as' => 'article_category.detail', 'uses' => 'Article_category@detail']);
    Route::patch('/update/{id}', ['as' => 'article_category.update', 'uses' => 'Article_category@update']);
    Route::get('/delete/{id}', ['as' => 'article_category.delete', 'uses' => 'Article_category@delete']);
    Route::get('/create', ['as' => 'article_category.create', 'uses' => 'Article_category@create']);
    Route::post('/', ['as' => 'article_category.search', 'uses' => 'Article_category@index']);
    Route::post('/delete_row', ['as' => 'article_category.delete_row', 'uses' => 'Article_category@delete_row']);
});