<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

// JSON API menggunakan session Laravel lokal agar tetap kompatibel dengan login web TBN.
Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AnalyticsController::class, 'apiDashboard'])->name('api.dashboard');
    Route::get('/ranking', [AnalyticsController::class, 'apiRanking'])->name('api.ranking');
    Route::get('/income', [AnalyticsController::class, 'apiIncome'])->name('api.income');
    Route::get('/me', [ProfileController::class, 'apiShow'])->name('api.me');
    Route::get('/points', [PointsController::class, 'api'])->name('api.points');
    Route::post('/ai/chat', [AiController::class, 'chat'])->middleware('throttle:20,1')->name('api.ai.chat');
    Route::post('/ai/identify', [AiController::class, 'identify'])->middleware('throttle:10,1')->name('api.ai.identify');
    Route::get('/vouchers', [VoucherController::class, 'api'])->name('api.vouchers');
    Route::post('/vouchers/{voucher}/redeem', [PointsController::class, 'redeemApi'])->name('api.vouchers.redeem');
});
