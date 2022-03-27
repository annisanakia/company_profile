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

Route::group(['prefix' => 'menu', 'namespace' => 'App\Modules\Menu\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'menu.index', 'uses' => 'Menu@index']);
    Route::post('/store', ['as' => 'menu.store', 'uses' => 'Menu@store']);
    Route::get('/edit/{id}', ['as' => 'menu.edit', 'uses' => 'Menu@edit']);
    Route::get('/detail/{id}', ['as' => 'menu.detail', 'uses' => 'Menu@detail']);
    Route::patch('/update/{id}', ['as' => 'menu.update', 'uses' => 'Menu@update']);
    Route::get('/delete/{id}', ['as' => 'menu.delete', 'uses' => 'Menu@delete']);
    Route::get('/create', ['as' => 'menu.create', 'uses' => 'Menu@create']);
    Route::post('/', ['as' => 'menu.search', 'uses' => 'Menu@index']);
    Route::post('/delete_row', ['as' => 'menu.delete_row', 'uses' => 'Menu@delete_row']);
    Route::get('/filterComponent', ['as' => 'menu.filterComponent', 'uses' => 'Menu@filterComponent']);
});