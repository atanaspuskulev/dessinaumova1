<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\Orders;
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

    public function getIdsFromCart(): array
    {
        $ids = [];

        foreach(session()->get('cart', []) as $cartProduct) {
            $ids[] = $cartProduct['product_id'];
        }

        return $ids;
    }

    function generateOrderNumber(): string {
        $prefix = "ORD";
        $date = date("Ymd"); // YYYYMMDD format
        $lastOrderNumber = $this->getLastOrderNum(); // Fetch from DB or Cache
        $nextOrderNumber = str_pad((string)$lastOrderNumber, 4, "0", STR_PAD_LEFT);

        return "{$prefix}-{$date}-{$nextOrderNumber}";
    }

    public function getLastOrderNum(): int
    {
        $lastOrder = Orders::latest('id')->first();

        return $lastOrder ? (int) $lastOrder->order_num + 1 : 1;
    }
}
