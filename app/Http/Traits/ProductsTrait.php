<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\Product;

trait ProductsTrait
{
    public function forceDeleteProduct(Product $product): void
    {
        if($product->gallery && $product->gallery->count() > 0) {
            foreach($product->gallery as $image) {
                $this->deleteImage($product, $image);
                $image->delete();
            }
        }

        $product->forceDelete();
    }
}
