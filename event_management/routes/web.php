<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RSVPController;
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
    return view('layout.app');
});
Route::get( '/welcome', function () {
    return view( 'welcome' );
} );
Route::get( '/user-reg', [UserController::class, 'UserRegPage'] );
Route::get( '/user-login', [UserController::class, 'LogInPage'] );
Route::get( '/user-logout', [UserController::class, 'LogOutPage'] );
Route::get( '/send-otp', [UserController::class, 'SendOtpPage'] );
Route::get( '/verify-otp', [UserController::class, 'VerifyOtpPage'] );
Route::get( '/reset-password', [UserController::class, 'ResetPassPage'] )->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/dashboard', [DashboardController::class, 'dashboardPage'] )->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/profile', [DashboardController::class, 'ProfilePage'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/userProfile/{id}', [DashboardController::class, 'userProfileDetails'] );

Route::get( '/profile-update', [DashboardController::class, 'ProfileUpdatePage'] )->middleware( [TokenVerificationMiddleware::class] );

//Event Page
Route::get( '/events', [EventController::class, 'eventPage'] )->middleware( [TokenVerificationMiddleware::class] );

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

//Event API
Route::get( '/allEvent', [EventController::class, 'index'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/event-by-id', [EventController::class, 'ReqById'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/create-event', [EventController::class, 'storeEvent'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/update-event', [EventController::class, 'updateEvent'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/delete-event', [EventController::class, 'deleteEvent'] )->middleware( [TokenVerificationMiddleware::class] );

// Routes for Events
Route::get( 'events/{event}', [EventController::class, 'show'] );

// Routes for RSVP
Route::group( ['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::get( 'events/{event}/rsvp', [RSVPController::class, 'create'] )->name( 'rsvp.create' );
    Route::post( 'events/{event}/rsvp', [RSVPController::class, 'store'] )->name( 'rsvp.store' );
} );