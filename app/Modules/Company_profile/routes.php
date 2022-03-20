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
    Route::post('/', ['as' => 'company_profile.search', 'uses' => 'Company_profile@index']);
    Route::get('/company_information', ['as' => 'company_profile.company_information', 'uses' => 'Company_profile@company_information']);
    Route::post('/detailInformationSave', ['as' => 'company_profile.detailInformationSave', 'uses' => 'Company_profile@detailInformationSave']);
    Route::get('/company_team', ['as' => 'company_profile.company_team', 'uses' => 'Company_profile@company_team']);
    Route::get('/header_config', ['as' => 'company_profile.header_config', 'uses' => 'Company_profile@header_config']);
    Route::get('/other_information', ['as' => 'company_profile.other_information', 'uses' => 'Company_profile@other_information']);
});