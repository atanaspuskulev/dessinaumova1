<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;

Route::name('front.')->group(function () {
    Route::get('/', [Front\HomeController::class, 'index'])->name('index');
    Route::get('/{category}', [Front\ProductsController::class, 'byCategory'])->name('to_category');
    Route::get('/{category_slug}/{product_slug}')->name('product_view');
});
