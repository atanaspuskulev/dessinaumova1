<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;

Route::name('front.')->middleware('web')->group(function () {

    Route::get('/about-me', static function () {
        $page_title = 'За мен | Деси Наумова';
        $meta_description = 'Научете повече за Деси Наумова, моята история, ценности и преследване на качество. Discover what makes us a trusted source for hand-crafted paintings, candles, and wooden articles.';
        $meta_keywords = 'Деси Наумова, за Деси Наумова, моето изкуство, моята мисия, ръчно изработени продукти, картини, свещи, изкуство с дръво';

        return view('front.about', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('about');


    Route::get('/contact-me', static function() {
        $page_title = 'Контакти | Деси Наумова';
        $meta_description = 'Свържете се с Деси Наумова за запитвания, изработка по поръчка или сътрудничество.';
        $meta_keywords = 'пишете ми, Деси Наумова контакт';

        return view('front.contacts', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('contact');

    Route::get('/cookies-policy', static function() {
        $page_title = 'Бисквитки | Деси Наумова';
        $meta_description = 'Read ' . config('app.name') . '\'s Cookies Policy to learn how we interact with cookies.';
        $meta_keywords = 'cookies policy, Деси Наумова cookies policy';

        return view('front.cookies-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('cookies_policy');

    Route::get('/privacy-policy', static function() {
        $page_title = 'Политика за поверителност | Деси Наумова';
        $meta_description = 'Прочетете Политика за поверителност на Деси Наумова, за да разберете какво правим с вашата информация.';
        $meta_keywords = 'Политика за поверителност, Деси Наумова правна политика';

        return view('front.privacy-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('privacy_policy');

    Route::get('/terms-of-use', static function() {
        $page_title = 'Условия за ползване | Деси Наумова';
        $meta_description = 'Разберете Условия за ползване на Деси Наумова';
        $meta_keywords = 'Условия за ползване, Деси Наумова узп';

        return view('front.tos', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('terms_of_use');

    Route::get('/return-policy', static function() {
        $page_title = 'Политика на връщане | Деси Наумова';
        $meta_description = 'Научете повече за политиката на връщане на продукти на Деси Наумова';
        $meta_keywords = 'политика на връщане, Деси Наумова';

        return view('front.return-policy', compact('page_title', 'meta_description', 'meta_keywords'));
    })->name('return_policy');

    Route::post('/cart', [Front\AddToCartController::class, 'store'])->name('cart.add');
    Route::get('/tags', [Front\TagsController::class, 'index'])->name('tags');
    Route::get('/tag/{tag}', [Front\TagsController::class, 'show'])->name('by_tag');

    Route::get('/', [Front\HomeController::class, 'index'])->name('index');

    Route::get('/cart', Front\CartIndexController::class)->name('cart.index');

    Route::post('/cart/remove-product/{id}', [Front\CartController::class, 'removeFromCart'])->name('remove_product_from_cart');
    Route::post('/cart/update-quantity/{id}', [Front\CartController::class, 'updateQuantity'])->name('update_quantity');

    Route::post('/order/create', [Front\OrdersController::class, 'createOrder'])->name('order_create');
    Route::get('/order/completed', [Front\OrdersController::class, 'completed'])->name('order_completed');


    Route::get('/cart/checkout/delivery-information', [Front\DeliveryInformationController::class, 'deliveryForm'])->name('delivery_form');

    Route::match(['GET', 'POST'], '/cart/payment-and-delivery', [Front\PaymentController::class, 'paymentChoose'])->name('payment_and_delivery');

    Route::get('/{category}', [Front\ProductsController::class, 'byCategory'])
        ->where('category', '^(?!cart$)[\w-]+$') // Exclude 'cart' and allow word characters and hyphens
        ->name('to_category');

    Route::get('/{category_slug}/{product_slug}', [Front\ProductsController::class, 'view'])
        ->where(['category_slug' => '^(?!cart$)[\w-]+$', 'product_slug' => '^(?!cart$)[\w-]+$'])
        ->name('product_view');

});
