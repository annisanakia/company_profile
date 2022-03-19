<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'groups', 'namespace' => 'App\Modules\Groups\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'groups.index', 'uses' => 'Groups@index']);
    Route::post('/store', ['as' => 'groups.store', 'uses' => 'Groups@store']);
    Route::get('/edit/{id}', ['as' => 'groups.edit', 'uses' => 'Groups@edit']);
    Route::get('/detail/{id}', ['as' => 'groups.detail', 'uses' => 'Groups@detail']);
    Route::patch('/update/{id}', ['as' => 'groups.update', 'uses' => 'Groups@update']);
    Route::get('/delete/{id}', ['as' => 'groups.delete', 'uses' => 'Groups@delete']);
    Route::get('/create', ['as' => 'groups.create', 'uses' => 'Groups@create']);
    Route::post('/', ['as' => 'groups.search', 'uses' => 'Groups@index']);
    Route::post('/delete_row', ['as' => 'groups.delete_row', 'uses' => 'Groups@delete_row']);
});