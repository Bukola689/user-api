<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

      //....auth....//
      Route::group(['prefix'=> 'auth'], function() {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [loginController::class, 'login']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'reset_password_email']);
     Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [logoutController::class, 'logout']);
        Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
        Route::post('reset-password/{token}', [ResetPasswordController::class, 'reset']); 

     });
 });
