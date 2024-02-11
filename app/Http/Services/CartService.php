<?php

namespace App\Http\Services;

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

    public function empty(): void
    {
        session()->forget(self::CART_KEY);
    }
}
