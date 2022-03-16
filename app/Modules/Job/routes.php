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

Route::group(['prefix' => 'job', 'namespace' => 'App\Modules\Job\Controllers', 'middleware' => ['web']], function () {
    Route::get('/', ['as' => 'job.index', 'uses' => 'Job@index']);
    Route::post('/store', ['as' => 'job.store', 'uses' => 'Job@store']);
    Route::get('/edit/{id}', ['as' => 'job.edit', 'uses' => 'Job@edit']);
    Route::patch('/update/{id}', ['as' => 'job.update', 'uses' => 'Job@update']);
    Route::get('/delete/{id}', ['as' => 'job.delete', 'uses' => 'Job@delete']);
    Route::get('/create', ['as' => 'job.create', 'uses' => 'Job@create']);
    Route::post('/', ['as' => 'job.search', 'uses' => 'Job@index']);
    Route::post('/delete_row', ['as' => 'job.delete_row', 'uses' => 'Job@delete_row']);
});
