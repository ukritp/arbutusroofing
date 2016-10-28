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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::auth();

// Route::get('/home', 'HomeController@index');


// LOGIN ACCESS ONLY =========================================================================================================
Route::group(['middleware' => 'auth'], function () {

    // HOME route
    Route::get('/', ['as'=>'home','uses'=>'HomeController@index']);

    // ONLY ADMIN CAN ACCESS USER ROUTE
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {
        // USER Route
        Route::get('users/searchajax/{users?}', ['as' => 'users.searchajax','uses' => 'UserController@searchajax']);
        Route::get('users/search/{users?}', ['as' => 'users.search','uses' => 'UserController@search']);
        Route::get('users/{users}/edit_password', ['as' => 'users.edit_password', 'uses' => 'UserController@editPassword']);
        Route::put('users/password/{users}', ['as' => 'users.update_password', 'uses' => 'UserController@updatePassword']);
        Route::resource('users', 'UserController', ['except' => ['edit_password','update_password','search','searchajax']]);
    });

    // ONLY ADMIN CAN ACCESS COMPANY ROUTE
    Route::group(['middleware' => 'roles', 'roles' => ['Client']], function () {
        Route::get('companies/client/{companies?}', ['as' => 'companies.client','uses' => 'CompanyController@client']);
    });

    // ONLY ADMIN CAN ACCESS COMPANY ROUTE
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {
        // COMPANY Route
        Route::get('companies/searchajax/{companies?}', ['as' => 'companies.searchajax','uses' => 'CompanyController@searchajax']);
        Route::get('companies/search/{companies?}', ['as' => 'companies.search','uses' => 'CompanyController@search']);
        Route::get('companies/create/{companies?}', ['as' => 'companies.create', 'uses' => 'CompanyController@create']);
        Route::resource('companies', 'CompanyController', ['except' => ['create','search','searchajax','client']]);
    });

    // ONLY ADMIN CAN ACCESS PROPERTY ROUTE
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {
        // PROPERTY Route
        Route::get('properties/searchajax/{properties?}', ['as' => 'properties.searchajax','uses' => 'PropertyController@searchajax']);
        Route::get('properties/search/{properties?}', ['as' => 'properties.search','uses' => 'PropertyController@search']);
        Route::get('properties/create/{properties?}', ['as' => 'properties.create', 'uses' => 'PropertyController@create']);
        Route::resource('properties', 'PropertyController', ['except' => ['create','search','searchajax']]);
    });

    // ONLY ADMIN AND WORKER CAN ACCESS WORKER INVOICE AND IMAGE ROUTE
    Route::group(['middleware' => 'roles', 'roles' => ['Admin','Worker']], function () {
        // WORKORDER Route
        Route::get('workorders/searchajax/{workorders?}', ['as' => 'workorders.searchajax','uses' => 'WorkorderController@searchajax']);
        Route::get('workorders/search/{workorders?}', ['as' => 'workorders.search','uses' => 'WorkorderController@search']);
        Route::get('workorders/create/{workorders?}', ['as' => 'workorders.create', 'uses' => 'WorkorderController@create']);
        Route::resource('workorders', 'WorkorderController', ['except' => ['create','search','show']]);

        // UPLOAD IMAGE Route
        Route::get('uploadimages/download/{uploadimages}', ['as' => 'uploadimages.download', 'uses' => 'UploadImageController@download']);
        Route::get('uploadimages/create/{uploadimages}', ['as' => 'uploadimages.create', 'uses' => 'UploadImageController@create']);
        Route::resource('uploadimages', 'UploadImageController', ['except' => ['create','download']]);

        // INVOICE Route
        Route::get('invoices/create/{invoices}', ['as' => 'invoices.create', 'uses' => 'InvoiceController@create']);
        Route::resource('invoices', 'InvoiceController', ['except' => ['create','download']]);
    });

    // ALL USERS CAN ACCESS
    Route::group(['middleware' => 'roles', 'roles' => ['Admin','Worker','Client']], function () {
        Route::get('workorders/{workorders}', ['as' => 'workorders.show','uses' => 'WorkorderController@show']);
        Route::get('invoices/download/{invoices}', ['as' => 'invoices.download', 'uses' => 'InvoiceController@download']);
    });

}); // END LOGIN ACCESS ======================================================================================================
