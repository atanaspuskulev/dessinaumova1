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
        $categoryData = Category::where('slug', $category)->first();

        if (!$categoryData) {
            abort(404); // Handle the case where the category is not found
        }

        $products = $categoryData->products()->with('thumbnail')->paginate(10);

        return view('front.products', compact('categoryData', 'products'));
    }

    public function view(string $categorySlug, string $productSlug): View
    {
        $categoryData = Category::with([
            'products' => function($query) use ($productSlug) {
                $query->where('slug', $productSlug);
            },
            'products.thumbnail',
            'products.gallery'
        ])
        ->where('slug', $categorySlug)
        ->firstOrFail();

        return view('front.product_view', compact('categoryData'));
    }
}
