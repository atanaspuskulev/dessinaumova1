<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CartIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $cartService = new CartService(new SessionStorageService(), new ProductsService(), new PriceService());
        $data = $cartService->getCartPreviewData(new Category());

        return view('front.cart.index', $data);
    }
}
