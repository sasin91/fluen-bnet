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

//Route::auth();

Route::get('login', function () {
   return redirect()->route('bnet::auth::redirect');
});

Route::get('register', function () {
    return response("Registration disabled, please login and proceed from there.", 401);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@welcome');
});