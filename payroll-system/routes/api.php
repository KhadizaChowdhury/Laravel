<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User API
Route::post( '/login-user', [UserController::class, 'UserLogin'] )->name( 'login.store' );
Route::post( '/reg-user', [UserController::class, 'createUser'] );
Route::post( '/otp-send', [UserController::class, 'SendOTPCode'] );
Route::post( '/otp-verify', [UserController::class, 'VerifyOTP'] );

Route::get( '/user-profile', [DashboardController::class, 'UserProfile'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/allUser', [DashboardController::class, 'allUser'] );
Route::get( '/user/{id}', [DashboardController::class, 'userDetails'] );

Route::post( '/update-profile', [DashboardController::class, 'UpdateUser'] )->middleware( [TokenVerificationMiddleware::class] );
//Token Verify
Route::post( '/password-reset', [UserController::class, 'ResetPassword'] )->middleware( [TokenVerificationMiddleware::class] );