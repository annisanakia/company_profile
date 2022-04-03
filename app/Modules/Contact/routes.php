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

Route::group(['prefix' => 'contact', 'namespace' => 'App\Modules\Contact\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'contact.index', 'uses' => 'Contact@index']);
    Route::post('/', ['as' => 'contact.search', 'uses' => 'Contact@index']);
    Route::get('/detail/{id}', ['as' => 'contact.detail', 'uses' => 'Contact@detail']);
    Route::get('/delete/{id}', ['as' => 'contact.delete', 'uses' => 'Contact@delete']);
});