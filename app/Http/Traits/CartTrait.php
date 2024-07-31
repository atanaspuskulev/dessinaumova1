<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

trait CartTrait
{
    public function getProductsFromCart(bool|null $withRelationships = null, array $relationships = []): Collection
    {
        $withRelationships ??= true;
        return Product::when($withRelationships && !empty($relationships), static function($query) use ($relationships) {
            $query->with($relationships);
        })
        ->whereIn('id', session()->get('cart', []))
        ->get();
    }
}
