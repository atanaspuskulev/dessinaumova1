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
        $products = Product::with([
            'thumbnail',
            'category'
        ])
        ->where('sold', false)
        ->inRandomOrder()
        ->take(6)->get();

        $productsCount = $products->count();

        return view('front.index', compact('products', 'productsCount'));
    }
}
