<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user', 'Api\UserController@me');
Route::delete('user', 'Api\UserController@destroy');
Route::match(['PUT','PATCH'], 'user', 'Api\UserController@update');

Route::group(['namespace' => 'Api\Home', 'prefix' => 'home'], function () {
    Route::get('wow/characters', 'WarcraftController@getCharacters');
});