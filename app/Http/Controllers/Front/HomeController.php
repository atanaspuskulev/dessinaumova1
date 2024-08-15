<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = collect();

        Product::with(['thumbnail', 'category'])
            ->where('sold', false)
            ->chunk(100, function ($chunk) use ($products) {
                $chunk->groupBy('category_id')->each(function ($items) use ($products) {
                    $products->push($items->take(3));
                });
            });

        $products = $products->flatten();

        return view('front.index', compact('products'));
    }
}
