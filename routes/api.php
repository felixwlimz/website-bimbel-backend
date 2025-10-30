<?php

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'index']);
    Route::put('/user', [AuthController::class, 'update']);


    // Route::middleware('role:super_admin')->group(function () {
    //     Route::delete('/user/{id}', [AuthController::class, 'delete']);
    //     Route::delete('/questions/{id}', [QuestionController::class, 'delete']);
    //     Route::get('/transactions', action: [TransactionController::class, 'index']);
    //     Route::get('/users', action: [AuthController::class, 'getAllUsers']);
    // });

    Route::delete('/user/{id}', [AuthController::class, 'delete']);
    Route::delete('/questions/{id}', [QuestionController::class, 'delete']);
    Route::get('/transactions', action: [TransactionController::class, 'index']);
    Route::get('/users', action: [AuthController::class, 'getAllUsers']);
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::post('/affiliates', [AffiliateController::class, 'store']);
    Route::get('/affiliates', [AffiliateController::class, 'index']);
    Route::get('/withdrawals', [WithdrawalController::class, 'index']);
    Route::get('/materials', action: [MaterialController::class, 'index']);
    Route::post('/upload-materi', [MaterialController::class, 'store']);
    Route::post('/payments', [PaymentController::class, 'createPayment']);
    Route::post('/payments/notification', [PaymentController::class, 'notification']);
    Route::get('/packages', [PackageController::class, 'index']);
    Route::post('/packages', [PackageController::class, 'store']);
    Route::post('/landing-page', [LandingPageController::class, 'store']);
    Route::get('/landing-page', [LandingPageController::class, 'index']);
});
