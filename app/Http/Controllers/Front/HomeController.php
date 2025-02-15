<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $maincategory = Category::with('thumbnail')->orderBy('position')->first();

        $items = Category::with('thumbnail')->where('is_active', true)
            ->whereNot('id', $maincategory->id)
            ->orderBy('position')
            ->get();

        return view('front.index', compact('items', 'maincategory'));
    }
}
