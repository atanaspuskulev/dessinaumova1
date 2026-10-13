<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

readonly class CategoriesComposer
{
    public function compose(View $view)
    {
        $categories = cache()->remember('cached_categories', config('seo.tags.ttl'), function() {
            return Category::where('is_active', true)
                ->pluck('title', 'slug');
        });

        $view->with('products_categories', $categories);
    }
}
