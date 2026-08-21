<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/auth', [AuthController::class, 'show'])->name('auth.show');
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/email/verify', [AuthController::class, 'showVerificationCode'])->name('verification.code');
Route::post('/email/verify', [AuthController::class, 'verifyCode'])->name('verification.code.submit');
Route::post('/email/verification-code/resend', [AuthController::class, 'resendCode'])->name('verification.code.resend');
// Alias kompatibilitas untuk halaman verifikasi lama.
Route::post('/email/verify/resend', [AuthController::class, 'resendCode'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/beranda', [AuthController::class, 'dashboard'])->name('beranda');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/ranking', [AnalyticsController::class, 'ranking'])->name('ranking');
    Route::get('/penghasilan', [AnalyticsController::class, 'income'])->name('income');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/poin', [PointsController::class, 'index'])->name('points');
    Route::post('/poin/tukar/{voucher}', [PointsController::class, 'redeem'])->name('points.redeem');
    Route::middleware('role.manager')->group(function () {
        Route::get('/voucher', [VoucherController::class, 'index'])->name('vouchers');
        Route::post('/voucher', [VoucherController::class, 'store'])->name('vouchers.store');
        Route::put('/voucher/{voucher}', [VoucherController::class, 'update'])->name('vouchers.update');
        Route::delete('/voucher/{voucher}', [VoucherController::class, 'destroy'])->name('vouchers.destroy');
    });
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/ai/chat', [AiController::class, 'chat'])
        ->middleware('throttle:20,1')
        ->name('ai.chat');

    Route::post('/ai/identify', [AiController::class, 'identify'])
        ->middleware('throttle:10,1')
        ->name('ai.identify');
});
