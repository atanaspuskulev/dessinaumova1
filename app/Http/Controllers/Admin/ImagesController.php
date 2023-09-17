<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    use FileUploadTrait;

    public function destroy(Product $product, Images $image)
    {
        try {
            $imageObject = $product->gallery()->findOrFail($image->id);
            $this->deleteImage($product, $imageObject);
            $imageObject->delete();
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reorderImages(Request $request): void
    {
        if($request->has('product_id')) {
            $ordering = $request->get('order');

            if(!empty($ordering)) {
                $product = Product::with('gallery')
                    ->findOrFail($request->get('product_id'));

                $product->gallery()->update(['order' => 0]);

                $i = 0;
                foreach($ordering as $order) {
                    $product->gallery()->where('id', $order)->update(['order' => $i]);
                    $i++;
                }
                unset($i);
            }
        }
    }
}
