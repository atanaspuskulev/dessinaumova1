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
}
