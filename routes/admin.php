<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::prefix('admin')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('makeauth', [Admin\AuthController::class, 'authUser'])->name('admin.login_user');

    Route::middleware('admin.auth')->group(function () {
        Route::resource('orders', Admin\OrdersController::class);

        Route::post('view_order', [Admin\OrdersController::class, 'viewOrder'])->name('admin.view_order');

        Route::get('logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [Admin\IndexController::class, 'index'])->name('admin.home');
        Route::get('/order/regenerate-invoce/{id}', [Admin\OrdersController::class, 'regenerateInvoice'])->name('admin.regenerate_invoice');

        Route::post('/products/reorder-images', [Admin\ImagesController::class, 'reorderImages'])->name('admin.product.reorder_images');

        Route::delete('products/{product}/force-delete', [Admin\ProductsController::class, 'forceDelete'])->name('products.force-delete');
        Route::post('products/{product}/restore', [Admin\ProductsController::class, 'restore'])->name('products.restore');
        Route::post('/products/reorder', [Admin\ProductsController::class, 'reorder'])->name('admin.products_reorder');

        Route::delete('categories/{category}/force-delete', [Admin\CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
        Route::post('categories/{category}/restore', [Admin\CategoriesController::class, 'restore'])->name('categories.restore');

        Route::resource('products', Admin\ProductsController::class);
        Route::resource('products.images', Admin\ImagesController::class);

        Route::resource('categories', Admin\CategoriesController::class);
    });
});
