<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;

Route::name('front.')->group(function () {
    Route::get('/', [Front\HomeController::class, 'index'])->name('index');

    Route::post('/cart/remove-product', [Front\CartController::class, 'removeFromCart'])->name('remove_product_from_cart');
//    Route::get('/cart/checkout/choose-payment', [Front\CheckoutController::class, 'paymentMethod'])->name('payment_method');
    Route::get('/cart/checkout/delivery-information', \App\Livewire\CheckoutDelivery::class)->name('delivery');
    Route::get('/cart/checkout/payment', \App\Livewire\Payment::class)->name('payment');


    Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
    Route::get('paypal/payment', [\App\Livewire\PayPal::class, 'payment'])->name('paypal.payment');
    Route::get('paypal/payment/success', [\App\Livewire\PayPalSuccess::class, 'success'])->name('paypal.payment.success');
    Route::get('paypal/payment/cancel', [\App\Livewire\PayPalCancel::class, 'cancel'])->name('paypal.payment.cancel');

    Route::resource('cart',Front\CartController::class);

    Route::get('/{category}', [Front\ProductsController::class, 'byCategory'])
        ->where('category', '^(?!cart$)[\w-]+$') // Exclude 'cart' and allow word characters and hyphens
        ->name('to_category');

    Route::get('/{category_slug}/{product_slug}', [Front\ProductsController::class, 'view'])
        ->where(['category_slug' => '^(?!cart$)[\w-]+$', 'product_slug' => '^(?!cart$)[\w-]+$']) // Exclude 'cart' and allow word characters and hyphens
        ->name('product_view');
});
