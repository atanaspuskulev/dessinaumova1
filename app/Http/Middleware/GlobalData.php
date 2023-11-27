<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Helpers\Cart;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GlobalData
{
    public function handle(Request $request, \Closure $next)
    {
        $categories = Category::where('is_active', true)
            ->get()
            ->pluck('title', 'slug');

        View::share([
            'products_categories' => $categories,
            'cart_items' => Cart::getCartFromSession()
        ]);

        return $next($request);
    }
}
