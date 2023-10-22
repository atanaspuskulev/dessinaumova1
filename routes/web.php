<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;


Route::name('front.')->group(function () {
    Route::get('/', [Front\HomeController::class, 'index'])->name('index');
    Route::get('/prints', [Front\ProductsController::class, 'byCategory'])->name('prints')->defaults('category', 'prints');
    Route::get('/paintings', [Front\ProductsController::class, 'byCategory'])->name('paintings')->defaults('category', 'paintings');
});
