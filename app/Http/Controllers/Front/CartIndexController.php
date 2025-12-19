<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\PriceService;
use App\Http\Traits\CartTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class CartIndexController extends Controller
{
    use CartTrait;

    public function __construct(private readonly PriceService $priceService)
    {
    }

    public function __invoke(Request $request): View
    {
        $products = Product::with('thumbnail')->whereIn('id', $this->getIdsFromCart())->get();
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        foreach($cart as $cartItem) {
            $totalPrice += $cartItem['real_price'];
        }

        $totalPrice = $this->priceService->formatPrice($totalPrice, 'EUR');

        return view('front.cart.index', compact('products', 'cart', 'totalPrice'));
    }
}
