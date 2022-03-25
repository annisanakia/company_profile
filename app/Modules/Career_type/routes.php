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

Route::group(['prefix' => 'career_type', 'namespace' => 'App\Modules\Career_type\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'career_type.index', 'uses' => 'Career_type@index']);
    Route::post('/store', ['as' => 'career_type.store', 'uses' => 'Career_type@store']);
    Route::get('/edit/{id}', ['as' => 'career_type.edit', 'uses' => 'Career_type@edit']);
    Route::get('/detail/{id}', ['as' => 'career_type.detail', 'uses' => 'Career_type@detail']);
    Route::patch('/update/{id}', ['as' => 'career_type.update', 'uses' => 'Career_type@update']);
    Route::get('/delete/{id}', ['as' => 'career_type.delete', 'uses' => 'Career_type@delete']);
    Route::get('/create', ['as' => 'career_type.create', 'uses' => 'Career_type@create']);
    Route::post('/', ['as' => 'career_type.search', 'uses' => 'Career_type@index']);
    Route::post('/delete_row', ['as' => 'career_type.delete_row', 'uses' => 'Career_type@delete_row']);
});