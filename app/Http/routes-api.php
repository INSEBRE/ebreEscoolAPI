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

Route::group(['prefix' => 'api/v1.0', 'middleware' => ['login']], function () {
    Route::get('user/{id}/user', 'UserController@index');

    Route::resource('user', 'UserController',
        ['only' => ['index', 'store', 'update', 'destroy', 'show']]
    );

    Route::resource('people', 'PeopleController',
        ['only' => ['index', 'store', 'update', 'destroy', 'show']]
    );
});
