<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

trait CartTrait
{
    public function getProductsFromCart(bool|null $withRelationships = null, array $relationships = []): Collection
    {
        $withRelationships ??= true;
        return Product::when($withRelationships && !empty($relationships), static function($query) use ($relationships) {
            $query->with($relationships);
        })
        ->whereIn('id', session()->get('cart', []))
        ->get();
    }

    public function clearCrefKeys(): void
    {
        session()->forget(['cref', 'session_cref']);
    }

    public function clearCartSession(): void
    {
        session()->forget([
            'cart',
            'cref',
            'session_cref',
            'delivery-information'
        ]);
    }

    public function getCartPreviewData(CartService $cartService, ProductsService $productsService, PriceService $priceService): array
    {
        $productsIds = $cartService->getCart();
        $products = $productsService->getByIds($productsIds, ['category', 'thumbnail']);

        $pricesCollection = $products->pluck('price');

        $totalPrice = $priceService->calculatePrice($pricesCollection, true, 0.20);
        $priceWithoutTax = $priceService->calculatePrice($pricesCollection);

        $taxAmount = $totalPrice - $priceWithoutTax;

        $categories = null;

        if(!$products->count()) {
            $categories = Category::all();
        }

        if(!$this->cartService->hasCartReferenceKey()) {
            $this->cartService->createReferenceKey();
        }

        $cart_reference_key = $this->cartService->getCartReferenceKey();

        return compact(
            'cart_reference_key',
            'products',
            'totalPrice',
            'categories',
            'taxAmount'
        );
    }
}
