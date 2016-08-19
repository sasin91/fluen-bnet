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

Route::group(['middleware'  =>  'auth'], function () {

    Route::get('/api/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['namespace' => 'App\Http\Api\Home'], function () {
        Route::resource('user', 'UserController');
    });

});