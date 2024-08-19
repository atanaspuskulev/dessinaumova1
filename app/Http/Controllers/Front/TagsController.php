<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $tags = cache()->remember('tags_list', config('seo.tags.ttl'), function () {
            return Tag::withCount('products')
                ->having('products_count', '>', 0)
                ->orderBy('name', 'asc')->get();
        });

        return view('front.tags.index', compact('tags'));
    }
}
