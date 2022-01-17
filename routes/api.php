<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanScheduleController;
use App\Http\Controllers\LoanTypeController;
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



Route::prefix("auth")->name("auth.")->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name("register");
    Route::post('login', [AuthController::class, 'login'])->name("login");
});

Route::middleware('auth:api')->group(function () {
    //Loan types
    Route::get('loan-type', [LoanTypeController::class, 'index'])->name('loan.type');
    Route::post('loan-type/create', [LoanTypeController::class, 'create'])->name('loan.type.create');

    // loan applications
    Route::get('my-loans', [LoanApplicationController::class, 'index'])->name('loans.view');
    Route::get('my-loans/applications/{loanApplication}/schedules', [LoanApplicationController::class, 'loanSchedule'])->name('loans.schedule');
    Route::post('my-loans/apply', [LoanApplicationController::class, 'create'])->name('loans.apply');
    Route::post('my-loans/approve', [LoanApplicationController::class, 'approve'])->name('loan.approve');

    //loan schedule
    Route::post('my-loans/remit', [LoanScheduleController::class, 'create'])->name('loans.remit');
});
