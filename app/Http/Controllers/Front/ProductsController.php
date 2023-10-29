<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function byCategory(string $category): View
    {
        $categoryData = Category::with([
            'products' => function($query) {
                $query->paginate(10);
            },
            'products.thumbnail'
        ])
        ->where('slug', $category)
        ->first();

        $products = $categoryData->products ?? [];
        return view('front.products', compact('categoryData', 'products'));
    }
}
