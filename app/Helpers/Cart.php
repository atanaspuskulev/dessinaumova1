<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Collection;

class Cart
{
    public static function getCartFromSession(): Collection
    {
        $total = 0;
        $products = null;
        $cart = session()->get('cart');

        if($cart) {
            $total = count($cart);
            $products = Product::with('thumbnail')
                ->whereIn('id', $cart)
                ->get();
        }

        return collect([
            'total_count' => $total,
            'cart_products' => $products
        ]);
    }
}
