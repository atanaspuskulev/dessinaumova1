<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with([
            'thumbnail',
            'category'
        ])
        ->inRandomOrder()
        ->take(6)->get();

        return view('front.index', compact('products'));
    }
}
