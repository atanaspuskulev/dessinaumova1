<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Traits\CartTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CartIndexController extends Controller
{
    use CartTrait;

    public function __construct(protected ProductsService $productsService, protected CartService $cartService, protected PriceService $priceService)
    {}

    public function __invoke(Request $request)
    {
        return view('front.cart.index', $this->getCartPreviewData($this->cartService, $this->productsService, $this->priceService));
    }
}
