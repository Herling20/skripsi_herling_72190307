<?php

use App\Http\Controllers\MahasiswaAuth\AuthenticatedSessionController;
use App\Http\Controllers\MahasiswaAuth\ConfirmablePasswordController;
use App\Http\Controllers\MahasiswaAuth\EmailVerificationNotificationController;
use App\Http\Controllers\MahasiswaAuth\EmailVerificationPromptController;
use App\Http\Controllers\MahasiswaAuth\NewPasswordController;
use App\Http\Controllers\MahasiswaAuth\PasswordController;
use App\Http\Controllers\MahasiswaAuth\PasswordResetLinkController;
use App\Http\Controllers\MahasiswaAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:mahasiswa')->group(function () {

    Route::get('mahasiswa/login', [AuthenticatedSessionController::class, 'create'])
                ->name('mahasiswa.login');

    Route::post('mahasiswa/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('mahasiswa/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('mahasiswa.password.request');

    Route::post('mahasiswa/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('mahasiswa.password.email');

    Route::get('mahasiswa/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('mahasiswa.password.reset');

    Route::post('mahasiswa/reset-password', [NewPasswordController::class, 'store'])
                ->name('mahasiswa.password.store');
});

Route::middleware('auth:mahasiswa')->group(function () {
    Route::get('mahasiswa/verify-email', EmailVerificationPromptController::class)
                ->name('mahasiswa.verification.notice');

    Route::get('mahasiswa/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('mahasiswa.verification.verify');

    Route::post('mahasiswa/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('mahasiswa.verification.send');

    Route::get('mahasiswa/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('mahasiswa.password.confirm');

    Route::post('mahasiswa/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('mahasiswa/password', [PasswordController::class, 'update'])->name('mahasiswa.password.update');

    Route::post('mahasiswa/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('mahasiswa.logout');
    
    Route::get('mahasiswa/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('mahasiswa.logout');
});
