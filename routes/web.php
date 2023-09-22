<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;


Route::name('front.')->group(function () {
    Route::get('/', [Front\HomeController::class, 'index'])->name('index');
});
