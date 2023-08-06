<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::prefix('admin')->group(function() {
    Route::get('login', [Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('makeauth', [Admin\AuthController::class, 'authUser'])->name('admin.login_user');

    Route::middleware('admin.auth')->group(function() {
        Route::get('logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [Admin\IndexController::class, 'index'])->name('admin.home');
        Route::resource('paintings', Admin\PaintingsController::class);
    });
});
