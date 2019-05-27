<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', ['uses' => 'WelcomeController@index']);
Route::get('/skins/{skin}/download', ['uses' => 'SkinDownloadsController@download']);
Route::get('/containers/{container}/player', ['as' => 'container.players.show', 'uses' => 'ContainerPlayersController@show']);

