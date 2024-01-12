<?php

use App\Http\Controllers\DosenAuth\AuthenticatedSessionController;
use App\Http\Controllers\DosenAuth\ConfirmablePasswordController;
use App\Http\Controllers\DosenAuth\EmailVerificationNotificationController;
use App\Http\Controllers\DosenAuth\EmailVerificationPromptController;
use App\Http\Controllers\DosenAuth\NewPasswordController;
use App\Http\Controllers\DosenAuth\PasswordController;
use App\Http\Controllers\DosenAuth\PasswordResetLinkController;
use App\Http\Controllers\DosenAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:dosen')->group(function () {

    Route::get('dosen/login', [AuthenticatedSessionController::class, 'create'])
                ->name('dosen.login');

    Route::post('dosen/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('dosen/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('dosen.password.request');

    Route::post('dosen/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('dosen.password.email');

    Route::get('dosen/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('dosen.password.reset');

    Route::post('dosen/reset-password', [NewPasswordController::class, 'store'])
                ->name('dosen.password.store');
});

Route::middleware('auth:dosen')->group(function () {
    Route::get('dosen/verify-email', EmailVerificationPromptController::class)
                ->name('dosen.verification.notice');

    Route::get('dosen/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('dosen.verification.verify');

    Route::post('dosen/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('dosen.verification.send');

    Route::get('dosen/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('dosen.password.confirm');

    Route::post('dosen/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('dosen/password', [PasswordController::class, 'update'])->name('dosen.password.update');

    Route::post('dosen/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('dosen.logout');

    Route::get('dosen/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('dosen.logout');
});
