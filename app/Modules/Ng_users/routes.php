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

Route::group(['prefix' => 'ng_users', 'namespace' => 'App\Modules\Ng_users\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'ng_users.index', 'uses' => 'Ng_users@index']);
    Route::post('/store', ['as' => 'ng_users.store', 'uses' => 'Ng_users@store']);
    Route::get('/edit/{id}', ['as' => 'ng_users.edit', 'uses' => 'Ng_users@edit']);
    Route::get('/detail/{id}', ['as' => 'ng_users.detail', 'uses' => 'Ng_users@detail']);
    Route::patch('/update/{id}', ['as' => 'ng_users.update', 'uses' => 'Ng_users@update']);
    Route::get('/delete/{id}', ['as' => 'ng_users.delete', 'uses' => 'Ng_users@delete']);
    Route::get('/create', ['as' => 'ng_users.create', 'uses' => 'Ng_users@create']);
    Route::post('/', ['as' => 'ng_users.search', 'uses' => 'Ng_users@index']);
    Route::post('/delete_row', ['as' => 'ng_users.delete_row', 'uses' => 'Ng_users@delete_row']);
});