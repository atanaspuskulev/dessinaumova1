<?php

namespace App\Http\Services;

use App\Models\Product;

class CartService
{
    private const CART_KEY = 'cart';
    private const CART_REFERENCE_KEY = 'cart_ref';

    public function add(mixed $value): void
    {
        $cartItems = session()->get(self::CART_KEY, []);

        if (!in_array($value, $cartItems, true)) {
            $cartItems[] = $value;
            session()->put(self::CART_KEY, $cartItems);
        }
    }

    public function hasCartReferenceKey(): bool
    {
        return $this->hasCartSession(self::CART_REFERENCE_KEY);
    }

    public function createReferenceKey(): void
    {
        session()->put(self::CART_REFERENCE_KEY, time());
    }

    public function getCartReferenceKey(): mixed
    {
        return session()->get(self::CART_REFERENCE_KEY);
    }

    public function hasCartSession(string $key): bool
    {
        return session()->has($key);
    }

    public function has(mixed $searchValue): bool
    {
        $items = session()->get(self::CART_KEY, []);

        return in_array($searchValue, $items, true);
    }

    public function getCart(bool $count = false): mixed
    {
        $cartItems = session()->get(self::CART_KEY, []);

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

        session()->put(self::CART_KEY, $products);
    }

    public function empty(): void
    {
        session()->forget(self::CART_KEY);
    }

    public function verifyCartProducts(array|int $products)
    {
        if(!is_array($products)) {
            $products = [$products];
        }

        return Product::whereIn('id', $products)->count() > 0;
    }
}
