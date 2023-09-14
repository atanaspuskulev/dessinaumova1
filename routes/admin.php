<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::prefix('admin')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('makeauth', [Admin\AuthController::class, 'authUser'])->name('admin.login_user');

    Route::middleware('admin.auth')->group(function () {
        Route::get('logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [Admin\IndexController::class, 'index'])->name('admin.home');

        Route::post('/products/reorder-images', [Admin\ProductsController::class, 'reorderImages'])->name('admin.product.reorder_images');

        Route::delete('products/{product}/force-delete', [Admin\ProductsController::class, 'forceDelete'])->name('products.force-delete');
        Route::post('products/{product}/restore', [Admin\ProductsController::class, 'restore'])->name('products.restore');

        Route::resource('products', Admin\ProductsController::class);
        Route::resource('products.images', Admin\ImagesController::class);
    });
});
