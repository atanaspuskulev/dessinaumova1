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
    public function checkValidCart(): bool
    {
        return session()->has('cart');
    }

    public function checkDeliveryAddress()
    {
        return session()->has('delivery-information');
    }

    public function checkCartRefererSource()
    {
        $returnTo = route('front.cart.index');

        $cref = session()->has('cref')
            ? (int) session()->get('cref')
            : null;

        $requestCref = request()->has('cref')
            ? (int) request()->get('cref')
            : (session()->has('session_cref') ? (int) session()->get('session_cref') : null);

        if(($cref && $requestCref) && ($cref === $requestCref)) {
            return true;
        }

        session()->forget('cref');
        return redirect()->to($returnTo);
    }

    public function calculateCartAmount(
        Collection $prices,
        bool|null  $applyTaxRate = null,
        float|null $taxRate = 0.15
    ): float
    {
        $applyTaxRate ??= false;
        $amount = 0.00;

        foreach($prices as $price) {
            $amount += $price;
        }

        if($applyTaxRate && $taxRate) {
            $taxAmount = $amount * $taxRate;
            $amount += $taxAmount;
        }

        return round($amount);
    }

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
            'current_payment_order_id',
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
