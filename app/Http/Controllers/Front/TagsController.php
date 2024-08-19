<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagsController extends Controller
{
    public function index(): View
    {
        $tags = cache()->remember('tags_list', config('seo.tags.ttl'), function () {
            return Tag::withCount('products')
                ->having('products_count', '>', 0)
                ->orderBy('name', 'asc')->get();
        });

        $page_title = 'Explore all categories';
        $meta_description = 'Discover all categories at Desi Naumova. Browse our collection of hand-crafted paintings, candles, and wooden articles by exploring our product tags.';
        $meta_keywords = 'product categories, explore categories, category overview, Desi Naumova, paintings, candles, wooden articles';

        return view('front.tags.index', compact('tags', 'page_title', 'meta_description', 'meta_keywords'));
    }

    public function show(string $tag): View
    {
        $tagData = Tag::where('name', $tag)->firstOrFail();
        $products = $tagData->products()->with([
            'thumbnail',
            'category'
        ])->paginate(10);

        $page_title = $tagData->name . ' products';
        $meta_description = 'Explore our collection of ' . $tagData->name . ' products at Desi Naumova. Discover unique paintings, candles, and wooden articles that add a personal touch to your home decor.';
        $meta_keywords = $tagData->name . ' products, buy ' . $tagData->name . ' products, Desi Naumova';

        return view('front.products_by_filter_tag', compact('tagData', 'products', 'page_title', 'meta_description', 'meta_keywords'));
    }
}
