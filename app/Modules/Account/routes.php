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

Route::group(['prefix' => 'account', 'namespace' => 'App\Modules\Account\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'account.index', 'uses' => 'Account@index']);
    Route::post('/store', ['as' => 'account.store', 'uses' => 'Account@store']);
    Route::get('/edit/{id}', ['as' => 'account.edit', 'uses' => 'Account@edit']);
    Route::get('/detail/{id}', ['as' => 'account.detail', 'uses' => 'Account@detail']);
    Route::patch('/update/{id}', ['as' => 'account.update', 'uses' => 'Account@update']);
    Route::get('/delete/{id}', ['as' => 'account.delete', 'uses' => 'Account@delete']);
    Route::get('/create', ['as' => 'account.create', 'uses' => 'Account@create']);
    Route::post('/', ['as' => 'account.search', 'uses' => 'Account@index']);
    Route::post('/delete_row', ['as' => 'account.delete_row', 'uses' => 'Account@delete_row']);
});