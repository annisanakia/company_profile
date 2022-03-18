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

Route::group(['prefix' => 'ng_menu', 'namespace' => 'App\Modules\Ng_menu\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'ng_menu.index', 'uses' => 'Ng_menu@index']);
    Route::post('/store', ['as' => 'ng_menu.store', 'uses' => 'Ng_menu@store']);
    Route::get('/edit/{id}', ['as' => 'ng_menu.edit', 'uses' => 'Ng_menu@edit']);
    Route::get('/detail/{id}', ['as' => 'ng_menu.detail', 'uses' => 'Ng_menu@detail']);
    Route::patch('/update/{id}', ['as' => 'ng_menu.update', 'uses' => 'Ng_menu@update']);
    Route::get('/delete/{id}', ['as' => 'ng_menu.delete', 'uses' => 'Ng_menu@delete']);
    Route::get('/create', ['as' => 'ng_menu.create', 'uses' => 'Ng_menu@create']);
    Route::post('/', ['as' => 'ng_menu.search', 'uses' => 'Ng_menu@index']);
    Route::post('/delete_row', ['as' => 'ng_menu.delete_row', 'uses' => 'Ng_menu@delete_row']);
    Route::get('/filterComponent', ['as' => 'ng_menu.filterComponent', 'uses' => 'Ng_menu@filterComponent']);
});