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
    Route::get('/addTeam', ['as' => 'company_profile.addTeam', 'uses' => 'Company_profile@addTeam']);
    Route::get('/editTeam', ['as' => 'company_profile.editTeam', 'uses' => 'Company_profile@editTeam']);
    Route::get('/deleteTeam', ['as' => 'company_profile.deleteTeam', 'uses' => 'Company_profile@deleteTeam']);
    Route::post('/saveTeam', ['as' => 'company_profile.saveTeam', 'uses' => 'Company_profile@saveTeam']);
    Route::get('/header_config', ['as' => 'company_profile.header_config', 'uses' => 'Company_profile@header_config']);
    Route::get('/filterHeaderContent', ['as' => 'company_profile.filterHeaderContent', 'uses' => 'Company_profile@filterHeaderContent']);
    Route::get('/editHeader', ['as' => 'company_profile.editHeader', 'uses' => 'Company_profile@editHeader']);
    Route::post('/saveHeader', ['as' => 'company_profile.saveHeader', 'uses' => 'Company_profile@saveHeader']);
    Route::get('/deleteHeader', ['as' => 'company_profile.deleteHeader', 'uses' => 'Company_profile@deleteHeader']);
    Route::get('/customer', ['as' => 'company_profile.customer', 'uses' => 'Company_profile@customer']);
    Route::get('/editCustomer', ['as' => 'company_profile.editCustomer', 'uses' => 'Company_profile@editCustomer']);
    Route::post('/saveCustomer', ['as' => 'company_profile.saveCustomer', 'uses' => 'Company_profile@saveCustomer']);
    Route::get('/deleteCustomer', ['as' => 'company_profile.deleteCustomer', 'uses' => 'Company_profile@deleteCustomer']);
    Route::get('/editTestimoni', ['as' => 'company_profile.editTestimoni', 'uses' => 'Company_profile@editTestimoni']);
    Route::post('/saveTestimoni', ['as' => 'company_profile.saveTestimoni', 'uses' => 'Company_profile@saveTestimoni']);
    Route::get('/deleteTestimoni', ['as' => 'company_profile.deleteTestimoni', 'uses' => 'Company_profile@deleteTestimoni']);
    Route::get('/other_information', ['as' => 'company_profile.other_information', 'uses' => 'Company_profile@other_information']);
    Route::get('/editQuality', ['as' => 'company_profile.editQuality', 'uses' => 'Company_profile@editQuality']);
    Route::post('/saveQuality', ['as' => 'company_profile.saveQuality', 'uses' => 'Company_profile@saveQuality']);
    Route::get('/deleteQuality', ['as' => 'company_profile.deleteQuality', 'uses' => 'Company_profile@deleteQuality']);
});