<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveCategoryController;
use App\Http\Controllers\LeaveReportController;
use App\Http\Controllers\LeaveRequestController;
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

// routes/web.php
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

Route::get( '/dashboard', [DashboardController::class, 'dashboardPage'] )->middleware('tokenAndManager');

Route::get( '/profile', [DashboardController::class, 'ProfilePage'] )->middleware('tokenAndManager');
Route::get( '/userProfile/{id}', [DashboardController::class, 'userProfileDetails'] )->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/profile-update', [DashboardController::class, 'ProfileUpdatePage'] )->middleware( [TokenVerificationMiddleware::class] );

//User API
Route::post( '/login-user', [UserController::class, 'UserLogin'] )->name( 'login.store' );
Route::post( '/reg-user', [UserController::class, 'createUser'] );
Route::post( '/otp-send', [UserController::class, 'SendOTPCode'] );
Route::post( '/otp-verify', [UserController::class, 'VerifyOTP'] );

Route::get( '/user-profile', [DashboardController::class, 'UserProfile'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/list-user', [DashboardController::class, 'userList'] )->middleware('tokenAndManager');
Route::post( '/delete-user', [DashboardController::class, 'delete'] )->middleware('tokenAndManager');
Route::post( '/user-by-id', [DashboardController::class, 'ReqById'] )->middleware('tokenAndManager');
Route::get( '/user/{id}', [DashboardController::class, 'userDetails'] )->middleware('tokenAndManager');

Route::post( '/update-profile', [DashboardController::class, 'UpdateUser'] )->middleware('tokenAndManager');
Route::post( '/updateProfile', [DashboardController::class, 'UpdateUserProfile'] )->middleware( [TokenVerificationMiddleware::class] );
//Token Verify
Route::post( '/password-reset', [UserController::class, 'ResetPassword'] )->middleware( [TokenVerificationMiddleware::class] );

//LeaveCategory Page
Route::get( '/leaveCategories', [leaveCategoryController::class, 'leaveCategoryPage'] )->middleware( [TokenVerificationMiddleware::class] );

//LeaveCategory API

Route::get( '/list-leaveCategory', [LeaveCategoryController::class, 'index'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/leaveCategory-by-id', [LeaveCategoryController::class, 'ReqById'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/create-leaveCategory', [LeaveCategoryController::class, 'storeLeaveCategory'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/update-leaveCategory', [LeaveCategoryController::class, 'updateLeaveCategory'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/delete-leaveCategory', [LeaveCategoryController::class, 'deleteLeaveCategory'] )->middleware( [TokenVerificationMiddleware::class] );

// Routes for LeaveCategories
Route::get( 'leaveCategories/{leaveCategory}', [LeaveCategoryController::class, 'show'] );

//LeaveRequest Page
Route::get( '/checkLeaveRequest', [leaveRequestController::class, 'leaveRequestPage'] )->middleware('tokenAndManager');
Route::get( '/create-leaveRequest', [LeaveRequestController::class, 'createPage'] )->middleware( [TokenVerificationMiddleware::class] );

//LeaveRequest API
Route::get( '/get-leave-categories', [LeaveRequestController::class, 'getAll'] )->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/create-leaveRequest', [LeaveRequestController::class, 'store'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/list-leaveRequest', [LeaveRequestController::class, 'index'] )->middleware('tokenAndManager');
Route::post( '/leaveRequest-by-id', [LeaveRequestController::class, 'ReqById'] )->middleware('tokenAndManager');
Route::post( '/update-leaveRequest', [LeaveRequestController::class, 'update'] )->middleware('tokenAndManager');
Route::post( '/delete-leaveRequest', [LeaveRequestController::class, 'delete'] )->middleware('tokenAndManager');

Route::get( '/list-report', [LeaveReportController::class, 'index'] )->middleware( 'tokenAndManager' );
Route::get( '/users/{userId}/reports', [LeaveReportController::class, 'fetchUserReports'] )->middleware( 'tokenAndManager' );
Route::get( '/reports', [LeaveReportController::class, 'ReportPage'] )->middleware( 'tokenAndManager' );
Route::post( '/reports-by-userId', [LeaveReportController::class, 'ReqById'] )->middleware( 'tokenAndManager' );