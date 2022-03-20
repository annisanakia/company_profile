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

Route::group(['prefix' => 'company_profile', 'namespace' => 'App\Modules\Company_profile\Controllers', 'middleware' => ['web']], function () {
	Route::get('/', ['as' => 'company_profile.index', 'uses' => 'Company_profile@index']);
    Route::post('/store', ['as' => 'company_profile.store', 'uses' => 'Company_profile@store']);
    Route::get('/edit/{id}', ['as' => 'company_profile.edit', 'uses' => 'Company_profile@edit']);
    Route::get('/detail/{id}', ['as' => 'company_profile.detail', 'uses' => 'Company_profile@detail']);
    Route::patch('/update/{id}', ['as' => 'company_profile.update', 'uses' => 'Company_profile@update']);
    Route::get('/delete/{id}', ['as' => 'company_profile.delete', 'uses' => 'Company_profile@delete']);
    Route::get('/create', ['as' => 'company_profile.create', 'uses' => 'Company_profile@create']);
    Route::post('/', ['as' => 'company_profile.search', 'uses' => 'Company_profile@index']);
    Route::post('/delete_row', ['as' => 'company_profile.delete_row', 'uses' => 'Company_profile@delete_row']);
});