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

        return view('front.tags.index', compact('tags'));
    }

    public function show(string $tag): View
    {
        $tagData = Tag::where('name', $tag)->firstOrFail();
        $products = $tagData->products()->with([
            'thumbnail',
            'category'
        ])->paginate(10);

        return view('front.products_by_filter_tag', compact('tagData', 'products'));
    }
}
