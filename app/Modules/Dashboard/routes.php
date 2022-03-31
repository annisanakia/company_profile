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

Route::group(['prefix' => '', 'namespace' => 'App\Modules\Dashboard\Controllers', 'middleware' => ['web']], function () {
    Route::get('/read/{menu}.html', ['as' => 'dashboard.read', 'uses' => '\App\Modules\Dashboard\Controllers\Dashboard@read']);
    Route::get('/category/{category}.html', ['as' => 'dashboard.category', 'uses' => '\App\Modules\Dashboard\Controllers\Dashboard@category']);
    Route::get('/read/{menu}/{year}/{month}/{slug}.html', ['as' => 'dashboard.read', 'uses' => '\App\Modules\Dashboard\Controllers\Dashboard@read']);
});
