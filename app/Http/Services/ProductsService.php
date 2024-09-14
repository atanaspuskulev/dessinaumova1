<?php

namespace App\Http\Services;

use App\Http\Services\Interfaces\StorageServiceInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductsService
{
    public function isValidProductById(int $id): bool
    {
        return (bool) Product::find($id);
    }

    public function getByIds(array $ids, array $relationships = []): Collection
    {
        return Product::with($relationships)
            ->whereIn('id', $ids)
            ->get();
    }

    public function getProductItemsWithTemplate(Collection $items): string
    {
        return view('admin.partials.order_view_item', compact('items'))->render();
    }

    public function getProductsBy(array $criteria, $loadRelationships): Collection
    {
        $productsQuery = Product::query();

        if($loadRelationships) {
            $productsQuery->with($loadRelationships);
        }

        foreach($criteria as $key => $value) {
            $productsQuery->where($key, $value);
        }

        return $productsQuery->get();
    }
}
