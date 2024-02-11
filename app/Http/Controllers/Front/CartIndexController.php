<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Models\Category;
use Illuminate\Http\Request;

class CartIndexController extends Controller
{
    public function __construct(protected ProductsService $productsService, protected CartService $cartService, protected PriceService $priceService)
    {}

    public function __invoke(Request $request)
    {
        $productsIds = $this->cartService->getCart();
        $products = $this->productsService->getByIds($productsIds, ['category', 'thumbnail']);

        $pricesCollection = $products->pluck('price');

        $totalPrice = $this->priceService->calculatePrice($pricesCollection, true, 0.20);
        $priceWithoutTax = $this->priceService->calculatePrice($pricesCollection);

        $taxAmount = $totalPrice - $priceWithoutTax;

        if(!$products->count()) {
            $categories = Category::all();
        }


    }
}
