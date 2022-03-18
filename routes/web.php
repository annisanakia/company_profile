<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', ['as' => 'home.index', 'uses' => '\App\Modules\Home\Controllers\Home@index']);
Route::get('/', ['as' => 'dashboard.index', 'uses' => '\App\Modules\Dashboard\Controllers\Dashboard@index']);
Route::get('/dashboard.html', ['as' => 'dashboard.index', 'uses' => '\App\Modules\Dashboard\Controllers\Dashboard@index']);


