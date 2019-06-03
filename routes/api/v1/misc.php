<?php

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

Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

Route::post('/password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::post('/password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@reset']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('/refresh', ['as' => 'refresh', 'uses' => 'AuthController@refresh']);
    Route::post('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@show']);
});
