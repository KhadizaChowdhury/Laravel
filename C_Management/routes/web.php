<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page Route
Route::get('/', function () {
    return view('layouts.app');
});
Route::get( '/user-reg', [UserController::class, 'UserRegPage'] );
Route::get( '/user-login', [UserController::class, 'LogInPage'] );
Route::get( '/user-logout', [UserController::class, 'LogOutPage'] );
Route::get( '/send-otp', [UserController::class, 'SendOtpPage'] );
Route::get( '/verify-otp', [UserController::class, 'VerifyOtpPage'] );
Route::get( '/reset-password', [UserController::class, 'ResetPassPage'] )->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/dashboard', [TaskController::class, 'dashboardPage'] )->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/profile', [TaskController::class, 'ProfilePage'] );

// Route::resource( 'tasks', TaskController::class );

Route::group( ['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::resource( 'tasks', TaskController::class );
} );



Route::post( '/reg-user', [UserController::class, 'createUser'] );
Route::post( '/login-user', [UserController::class, 'UserLogin'] )->name('login.store');
Route::post( '/otp-send', [UserController::class, 'SendOTPCode'] );
Route::post( '/otp-verify', [UserController::class, 'VerifyOTP'] );
//Token Verify
Route::post( '/password-reset', [UserController::class, 'ResetPassword'] )->middleware([TokenVerificationMiddleware::class]);
