<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function byCategory(string $slug): View
    {
        $category = Category::with([
            'products' => function($query) {
                $query->paginate(10);
            },
            'products.thumbnail'
        ])
        ->where('slug', $slug)
        ->first();

        $products = $category->products;

        return view('front.products', compact('products'));
    }
}
