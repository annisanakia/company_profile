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

Route::group(['prefix' => 'career', 'namespace' => 'App\Modules\Career\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'career.index', 'uses' => 'Career@index']);
    Route::post('/store', ['as' => 'career.store', 'uses' => 'Career@store']);
    Route::get('/edit/{id}', ['as' => 'career.edit', 'uses' => 'Career@edit']);
    Route::get('/detail/{id}', ['as' => 'career.detail', 'uses' => 'Career@detail']);
    Route::patch('/update/{id}', ['as' => 'career.update', 'uses' => 'Career@update']);
    Route::get('/delete/{id}', ['as' => 'career.delete', 'uses' => 'Career@delete']);
    Route::get('/create', ['as' => 'career.create', 'uses' => 'Career@create']);
    Route::post('/', ['as' => 'career.search', 'uses' => 'Career@index']);
    Route::post('/delete_row', ['as' => 'career.delete_row', 'uses' => 'Career@delete_row']);
});