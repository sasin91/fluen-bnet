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
Route::get('/auth/battleNet', 'Auth\RegisterController@redirectToBattleNet');
Route::get('/auth/battleNet/callback', 'Auth\RegisterController@handleBattleNetCallback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@welcome');
});