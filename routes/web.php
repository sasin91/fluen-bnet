<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'WelcomeController@greet');

Route::auth();

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'home'], function () {
        Route::get('/', 'HomeController@welcome');
        Route::get('/api', 'HomeController@api');
    });
});