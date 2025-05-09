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
        $categoryData = Category::where('slug', $category)
            ->where('is_active', true)
            ->first();

        if (!$categoryData) {
            abort(404);
        }

        $products = $categoryData->products()->with(['thumbnail', 'category'])->paginate(10);
        $page_title = $categoryData->title;
        $meta_description = $categoryData->meta_description;
        $meta_keywords = $categoryData->meta_keywords;

        return view('front.products', compact(
            'categoryData',
            'products',
            'page_title',
            'meta_description',
            'meta_keywords'
        ));
    }

    public function view(string $categorySlug, string $productSlug): View
    {
        $categoryData = Category::with([
            'products' => static fn($query) => $query->where('slug', $productSlug)->firstOrFail(),
            'products.thumbnail',
            'products.gallery',
            'products.tags'
        ])
        ->where('slug', $categorySlug)
        ->firstOrFail();

        $product = $categoryData->products->first();

        $page_title = $product->meta_title;
        $meta_description = $product->meta_description;
        $meta_keywords = $product->meta_keywords;

        return view('front.product_view', compact(
            'categoryData',
            'page_title',
            'meta_description',
            'meta_keywords'
        ));
    }
}
