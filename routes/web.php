<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;

Route::name('front.')->group(function () {
    Route::get('/', [Front\HomeController::class, 'index'])->name('index');

    Route::resource('cart',Front\CartController::class);

    Route::get('/{category}', [Front\ProductsController::class, 'byCategory'])
        ->where('category', '^(?!cart$)[\w-]+$') // Exclude 'cart' and allow word characters and hyphens
        ->name('to_category');

    Route::get('/{category_slug}/{product_slug}', [Front\ProductsController::class, 'view'])
        ->where(['category_slug' => '^(?!cart$)[\w-]+$', 'product_slug' => '^(?!cart$)[\w-]+$']) // Exclude 'cart' and allow word characters and hyphens
        ->name('product_view');
});
