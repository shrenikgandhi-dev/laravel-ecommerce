<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ConfirmablePasswordController;
use App\Http\Controllers\Admin\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\EmailVerificationPromptController;
use App\Http\Controllers\Admin\NewPasswordController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PasswordResetLinkController;
use App\Http\Controllers\Admin\RegisteredUserController;
use App\Http\Controllers\Admin\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:' . config('constants.ADMIN_DIR'))->group(function () {
    Route::get(config('constants.ADMIN_DIR') . '/register', [RegisteredUserController::class, 'create'])
        ->name(config('constants.ADMIN_DIR') . '.register');

    Route::post(config('constants.ADMIN_DIR') . '/register', [RegisteredUserController::class, 'store'])
        ->name(config('constants.ADMIN_DIR') . '.register.store');

    Route::get(config('constants.ADMIN_DIR') . '/login', [AuthenticatedSessionController::class, 'create'])
        ->name(config('constants.ADMIN_DIR') . '.login');

    Route::post(config('constants.ADMIN_DIR') . '/login', [AuthenticatedSessionController::class, 'store'])
        ->name(config('constants.ADMIN_DIR') . '.login.store');

    Route::get(config('constants.ADMIN_DIR') . '/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name(config('constants.ADMIN_DIR') . '.password.request');

    Route::post(config('constants.ADMIN_DIR') . '/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name(config('constants.ADMIN_DIR') . '.password.email');

    Route::get(config('constants.ADMIN_DIR') . '/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name(config('constants.ADMIN_DIR') . '.password.reset');

    Route::post(config('constants.ADMIN_DIR') . '/reset-password', [NewPasswordController::class, 'store'])
        ->name(config('constants.ADMIN_DIR') . '.password.store');
});

Route::middleware('auth:' . config('constants.ADMIN_DIR'))->group(function () {
    Route::get(config('constants.ADMIN_DIR') . '/verify-email', EmailVerificationPromptController::class)
        ->name(config('constants.ADMIN_DIR') . '.verification.notice');

    Route::get(config('constants.ADMIN_DIR') . '/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name(config('constants.ADMIN_DIR') . '.verification.verify');

    Route::post(config('constants.ADMIN_DIR') . '/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name(config('constants.ADMIN_DIR') . '.verification.send');

    Route::get(config('constants.ADMIN_DIR') . '/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name(config('constants.ADMIN_DIR') . '.password.confirm');

    Route::post(config('constants.ADMIN_DIR') . '/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put(config('constants.ADMIN_DIR') . '/password', [PasswordController::class, 'update'])
        ->name(config('constants.ADMIN_DIR') . '.password.update');

    Route::post(config('constants.ADMIN_DIR') . '/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name(config('constants.ADMIN_DIR') . '.logout');

    Route::get(config('constants.ADMIN_DIR') . '/profile', [AdminProfileController::class, 'edit'])
        ->name(config('constants.ADMIN_DIR') . '.profile.edit');
    Route::patch(config('constants.ADMIN_DIR') . '/profile', [AdminProfileController::class, 'update'])
        ->name(config('constants.ADMIN_DIR') . '.profile.update');
    Route::delete(config('constants.ADMIN_DIR') . '/profile', [AdminProfileController::class, 'destroy'])
        ->name(config('constants.ADMIN_DIR') . '.profile.destroy');
});
