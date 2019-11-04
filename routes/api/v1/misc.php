<?php

use App\Http\Controllers\API\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\API\V1\Auth\ResetPasswordController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProfileController;

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

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('/password/email', ForgotPasswordController::class)->name('password.email');
Route::post('/password/reset', ResetPasswordController::class)->name('password.reset');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});
