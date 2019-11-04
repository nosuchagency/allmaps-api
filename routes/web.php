<?php

use App\Http\Controllers\ContainerPlayersController;
use App\Http\Controllers\SkinDownloadsController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/skins/{skin}/download', [SkinDownloadsController::class, 'download']);
Route::get('/containers/{container}/player', [ContainerPlayersController::class, 'show'])->name('container.players.show');

