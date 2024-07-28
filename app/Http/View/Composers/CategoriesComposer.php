<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

readonly class CategoriesComposer
{
    public function compose(View $view)
    {
        $categories = Category::where('is_active', true)
            ->get()
            ->pluck('title', 'slug');

        $view->with('products_categories', $categories);
    }
}
