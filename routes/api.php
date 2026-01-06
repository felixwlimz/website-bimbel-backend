<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    UserController,
    AffiliateController,
    WithdrawalController,
    PackageController,
    MaterialController,
    QuestionController,
    VoucherController,
    PaymentController,
    TransactionController,
    LandingPageController,
    AnswerSheetController,
    AnswerController,
    MidtransWebhookController,
    NotificationController
};

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [UserController::class, 'update']);

    Route::get('/transactions',           [TransactionController::class, 'history']);
    Route::get('/transactions/{invoice}', [TransactionController::class, 'show']);


    Route::get('/packages/{id}/materials', [MaterialController::class, 'byPackage']);
    Route::get('/packages/{id}/questions', [QuestionController::class, 'byPackage']);

    Route::post('/answer-sheets/{packageId}/start',  [AnswerSheetController::class, 'start']);
    Route::get('/answer-sheets/{packageId}/active', [AnswerSheetController::class, 'active']);
    Route::post('/answer-sheets/{sheetId}/submit',  [AnswerSheetController::class, 'submit']);

    Route::post('/answers/autosave',               [AnswerController::class, 'autosave']);
    Route::get('/answer-sheets/{sheetId}/answers', [AnswerController::class, 'bySheet']);


    Route::get('/affiliate/me',     [AffiliateController::class, 'me']);
    Route::post('/affiliate/apply', [AffiliateController::class, 'apply']);
    Route::get('/affiliates', action: [AffiliateController::class, 'index']);


    Route::get('/withdrawals/me', [WithdrawalController::class, 'byAffiliate']);
    Route::post('/withdrawals',   [WithdrawalController::class, 'store']);

    Route::post('/vouchers/check', [VoucherController::class, 'validate']);


    Route::middleware('role:admin,super_admin')->group(function () {

        Route::get('/users',         [UserController::class, 'index']);
        Route::get('/users/{id}',    [UserController::class, 'showById']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::get('/packages', [PackageController::class, 'index']);
        Route::post('/packages',        [PackageController::class, 'store']);
        Route::put('/packages/{id}',    action: [PackageController::class, 'update']);
        Route::delete('/packages/{id}', [PackageController::class, 'destroy']);

        /*
        | MATERIALS
        */
        Route::post('/materials', [MaterialController::class, 'store']);

        /*
        | QUESTIONS
        */
        Route::post('/questions',        [QuestionController::class, 'store']);
        Route::delete('/questions/{id}', [QuestionController::class, 'delete']);

        /*
        | AFFILIATES
        */
        Route::get('/affiliates',               [AffiliateController::class, 'index']);
        Route::post('/affiliates/{id}/approve', [AffiliateController::class, 'approve']);

        /*
        | WITHDRAWALS
        */
        Route::get('/withdrawals',               [WithdrawalController::class, 'index']);
        Route::post('/withdrawals/{id}/approve', [WithdrawalController::class, 'approve']);
        Route::post('/withdrawals/{id}/reject',  [WithdrawalController::class, 'reject']);

        /*
        | VOUCHERS
        */
        Route::get('/vouchers',         [VoucherController::class, 'index']);
        Route::post('/vouchers',        [VoucherController::class, 'store']);
        Route::put('/vouchers/{id}',    [VoucherController::class, 'update']);
        Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy']);

        /*
        | LANDING PAGES
        */
        Route::get('/landing-pages/admin',        [LandingPageController::class, 'index']);
        Route::post('/landing-pages',              [LandingPageController::class, 'store']);
        Route::post('/landing-pages/{id}/publish', [LandingPageController::class, 'publish']);
        Route::delete('/landing-pages/{id}',       [LandingPageController::class, 'delete']);

        Route::post('/payments', [PaymentController::class, 'create']);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);

        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    });
});

/*
|--------------------------------------------------------------------------
| PAYMENT WEBHOOK (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::post(
    '/payments/midtrans/webhook',
    [MidtransWebhookController::class, 'handle']
);
