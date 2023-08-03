<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin;

Route::prefix('admin')->group(function() {
    Route::get('login', Admin\Login::class)->name('admin.login');
    Route::post('login', Admin\Login::class)->name('admin.login_user');

    Route::middleware('admin.auth')->group(function() {
        Route::get('/', Admin\Index::class)->name('admin.home');
    });
});
