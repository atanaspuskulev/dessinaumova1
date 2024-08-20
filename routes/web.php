<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;

Route::name('front.')->middleware('web')->group(function () {

    Route::get('/about-me', static function () {
        $page_title = 'About Me | Desi Naumova';
        $meta_description = 'Learn more about Your Shop Name, our story, values, and commitment to quality. Discover what makes us a trusted source for hand-crafted paintings, candles, and wooden articles.';
        $meta_keywords = 'Desi Naumova, about Desi Naumova, my artwork, my mission, handmade products, paintings, candles, wooden articles';

        return view('front.about', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('about');


    Route::get('/contact-me', static function() {
        $page_title = 'Contact Me | Desi Naumova';
        $meta_description = 'Get in touch with Desi Naumova for inquiries, custom orders, or collaborations. I am are here to help you with any questions you may have about my products or services.';
        $meta_keywords = 'contact me, Desi Naumova contact, Desi Naumova location, get in touch';

        return view('front.contacts', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('contact');

    Route::get('/cookies-policy', static function() {
        $page_title = 'Cookies Policy | Desi Naumova';
        $meta_description = 'Read ' . config('app.name') . '\'s Cookies Policy to learn how we interact with cookies.';
        $meta_keywords = 'cookies policy, Desi Naumova cookies policy';

        return view('front.cookies-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('cookies_policy');

    Route::get('/privacy-policy', static function() {
        $page_title = 'Privacy Policy | Desi Naumova';
        $meta_description = 'Read ' . config('app.name') . '\'s Privacy Policy to learn how we handle your personal information.';
        $meta_keywords = 'privacy policy, Desi Naumova legal policy';

        return view('front.privacy-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('privacy_policy');

    Route::get('/terms-of-use', static function() {
        $page_title = 'Terms Of Use | Desi Naumova';
        $meta_description = 'Understand the Terms of Use for shopping at ' . config('app.name');
        $meta_keywords = 'terms of use, Desi Naumova tos';

        return view('front.tos', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('terms_of_use');

    Route::get('/return-policy', static function() {
        $page_title = 'Return Policy | Desi Naumova';
        $meta_description = 'Learn about ' . config('app.name') . '\'s Return Policy for hassle-free shopping';
        $meta_keywords = 'return policy, Desi Naumova';

        return view('front.return-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('return_policy');

    Route::get('/tags', [Front\TagsController::class, 'index'])->name('tags');
    Route::get('/tag/{tag}', [Front\TagsController::class, 'show'])->name('by_tag');

    Route::get('/', [Front\HomeController::class, 'index'])->name('index');

    Route::get('/cart', Front\CartIndexController::class)->name('cart.index');

    Route::post('/cart/remove-product', [Front\CartController::class, 'removeFromCart'])->name('remove_product_from_cart');

    Route::get('/order/success', [Front\OrdersController::class, 'captureAndComplete'])->name('payment.order.success');
    Route::get('/order/cancel', [Front\OrdersController::class, 'captureAndCancel'])->name('payment.order.cancel');
    Route::get('/order/test', [Front\OrdersController::class, 'test']);

    Route::post('/api/order/create', [Front\OrdersController::class, 'createOrder'])->name('payment.api.order.create');
    Route::post('/api/order/update', [Front\OrdersController::class, 'updateOrder'])->name('payment.api.order.update');
    Route::post('/api/order/cancel', [Front\OrdersController::class, 'cancelOrder'])->name('payment.api.order.cancel');
    // Payments

    Route::get('/cart/checkout/delivery-information', [Front\DeliveryInformationController::class, 'deliveryForm'])->name('delivery_form');
    Route::post('/cart/checkout/delivery-information', [Front\DeliveryInformationController::class, 'saveDeliveryInformation'])->name('saveDeliveryInformation');


    Route::get('/{category}', [Front\ProductsController::class, 'byCategory'])
        ->where('category', '^(?!cart$)[\w-]+$') // Exclude 'cart' and allow word characters and hyphens
        ->name('to_category');

    Route::get('/{category_slug}/{product_slug}', [Front\ProductsController::class, 'view'])
        ->where(['category_slug' => '^(?!cart$)[\w-]+$', 'product_slug' => '^(?!cart$)[\w-]+$'])
        ->name('product_view');

    Route::get('/cart/checkout/payment', [Front\PaymentController::class, 'index'])->name('checkout_cart_index_payment');
});
