<?php

use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/* admin routes */

Route::get(config('constants.ADMIN_DIR') . '/dashboard', function () {
    return Inertia::render('AdminDashboard');
})->middleware(['auth:' . config('constants.ADMIN_DIR'), 'verified'])->name(config('constants.ADMIN_DIR') . '.dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
