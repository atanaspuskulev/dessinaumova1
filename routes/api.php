<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;


Route::prefix('api')->group(function() {
   Route::post('/add-to-cart', Api\AddToCartController::class)->name('api.add_to_cart');
});
