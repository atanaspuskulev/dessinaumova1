<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Contracts\CleanupContractInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CartService implements CleanupContractInterface
{
    private const CART_KEY = 'cart';
    private const CART_REFERENCE_KEY = 'cart_ref';
    private SessionStorageService $sessionStorageService;
    private ProductsService $productsService;
    private PriceService $priceService;

    public function __construct(
        SessionStorageService $sessionStorageService,
        ProductsService $productsService,
        PriceService $priceService
    )
    {
        $this->sessionStorageService = $sessionStorageService;
        $this->productsService = $productsService;
        $this->priceService = $priceService;
    }

    public function add(mixed $value): void
    {
        $cartItems = $this->sessionStorageService->get(self::CART_KEY, []);

        if (!in_array($value, $cartItems, true)) {
            $cartItems[] = $value;
            $this->sessionStorageService->store(self::CART_KEY, $cartItems);
        }
    }

    public function hasCartReferenceKey(): bool
    {
        return $this->sessionStorageService->check(self::CART_REFERENCE_KEY);
    }

    public function createReferenceKey(): void
    {
        $this->sessionStorageService->store(self::CART_REFERENCE_KEY, time());
    }

    public function getCartReferenceKey(): mixed
    {
        return $this->sessionStorageService->get(self::CART_REFERENCE_KEY);
    }

    public function hasCartSession(string $key): bool
    {
        return $this->sessionStorageService->check($key);
    }

    public function has(mixed $searchValue): bool
    {
        $items = $this->sessionStorageService->get(self::CART_KEY, []);

        return in_array($searchValue, $items, true);
    }

    public function getCart(bool $count = false): mixed
    {
        $cartItems = $this->sessionStorageService->get(self::CART_KEY, []);

        return !$count ? $cartItems : count($cartItems);
    }

    public function remove(array|int $products): bool
    {
        if(!is_array($products)) {
            $products = [$products];
        }

        if(!$this->verifyCartProducts($products)) {
            return false;
        }

        $cart = $this->getCart();

        foreach($products as $product) {
            $searchIndex = array_search($product, $cart);

            if($searchIndex !== false) {
                unset($cart[$searchIndex]);
                $cart = array_values($cart);
            }
        }

        $this->flushWith($cart);

        return true;
    }

    public function flushWith(array|int $products): void
    {
        if(!is_array($products)) {
            $products = [$products];
        }

        $this->empty();

        $this->sessionStorageService->store(self::CART_KEY, $products);
    }

    public function empty(): void
    {
        $this->sessionStorageService->invalidate(self::CART_KEY);
    }

    public function verifyCartProducts(array|int $products): bool
    {
        if(!is_array($products)) {
            $products = [$products];
        }

        return Product::whereIn('id', $products)->count() > 0;
    }

    public function getCartPreviewData(Model $categoryModel): array
    {
        $productsIds = $this->getCart();

        $products = $this->productsService->getByIds($productsIds, ['category', 'thumbnail']);

        $prices = $products->pluck('price');
        $shippingCosts = $products->pluck('shipping_cost');

        $shippingPrice = $this->priceService->calculateShippingPrice($shippingCosts);
        $prices->push($shippingPrice);
        $totalPrice = $this->priceService->calculatePrice($prices, true, 0.20);
        $priceWithoutTax = $this->priceService->calculatePrice($prices);
        $taxAmount = $totalPrice - $priceWithoutTax;
        $categories = null;

        if(!$products->count()) {
            $categories = $categoryModel::query()->get();
        }

        if(!$this->hasCartReferenceKey()) {
            $this->createReferenceKey();
        }

        $cart_reference_key = $this->getCartReferenceKey();

        return compact(
            'cart_reference_key',
            'products',
            'totalPrice',
            'categories',
            'taxAmount',
            'shippingPrice'
        );
    }

    public function cleanupForSession(): void
    {
        $this->sessionStorageService->invalidate(['cart', 'cref']);
    }
}
