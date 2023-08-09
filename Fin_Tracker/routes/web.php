<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
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

// Route::resource( 'tasks', TaskController::class );

Route::group( ['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::resource( 'tasks', TaskController::class );
} );


//User
Route::post( '/reg-user', [UserController::class, 'createUser'] );
Route::post( '/login-user', [UserController::class, 'UserLogin'] )->name('login.store');
Route::post( '/otp-send', [UserController::class, 'SendOTPCode'] );
Route::post( '/otp-verify', [UserController::class, 'VerifyOTP'] );

Route::get( '/user-profile', [DashboardController::class, 'UserProfile'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/allUser', [DashboardController::class, 'allUser'] );
Route::get( '/user/{id}', [DashboardController::class, 'userDetails'] );

Route::post( '/update-profile', [DashboardController::class, 'UpdateUser'] )->middleware( [TokenVerificationMiddleware::class] );
//Token Verify
Route::post( '/password-reset', [UserController::class, 'ResetPassword'] )->middleware([TokenVerificationMiddleware::class]);



Route::get( '/incomes', [IncomeController::class, 'incomePage'] )->middleware([TokenVerificationMiddleware::class]);
Route::get( '/createIncome', [IncomeController::class, 'create'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/incomesById', [IncomeController::class, 'ReqById'] )->middleware([TokenVerificationMiddleware::class]);

Route::get( '/allIncome', [IncomeController::class, 'index'] )->middleware([TokenVerificationMiddleware::class]);
Route::post( '/income', [IncomeController::class, 'storeIncome'] )->middleware([TokenVerificationMiddleware::class]);
Route::put( '/updateIncome', [IncomeController::class, 'updateIncome'] )->middleware([TokenVerificationMiddleware::class]);
Route::delete( '/income/{income}', [IncomeController::class, 'deleteIncome'] )->middleware([TokenVerificationMiddleware::class]);

Route::get( '/expenses', [ExpenseController::class, 'expensePage'] )->middleware([TokenVerificationMiddleware::class]);
Route::get( '/createExpense', [ExpenseController::class, 'create'] )->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/expenseById', [ExpenseController::class, 'ReqById'] )->middleware([TokenVerificationMiddleware::class]);

Route::get( '/allExpense', [ExpenseController::class, 'index'] )->middleware([TokenVerificationMiddleware::class]);
Route::post( '/expense', [ExpenseController::class, 'storeExpense'] )->middleware([TokenVerificationMiddleware::class]);
Route::put( '/updateExpense', [ExpenseController::class, 'updateExpense'] )->middleware([TokenVerificationMiddleware::class]);
Route::delete( '/expense/{expense}', [ExpenseController::class, 'deleteExpense'] )->middleware([TokenVerificationMiddleware::class]);
