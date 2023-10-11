<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with([
            'thumbnail',
            'category'
        ])
        ->withTrashed()
        ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->all());

        $this->uploadFiles($request, 'images', $product);

        return redirect()->route('products.edit', ['product' => $product])
            ->with('message', sprintf("Successfully created product %s", $product->title));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $product->load('gallery');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();

        if(!isset($data['sold'])) {
            $data['sold'] = false;
        }

        $product->update($data);

        $this->uploadFiles($request, 'images', $product);

        return redirect()->route('products.edit', ['product' => $product])
            ->with('message', sprintf("Successfully updated product %s", $product->title));
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->delete();
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reorder(Request $request): void
    {
        $ordering = $request->get('order');
        if(!empty($ordering)) {
            $pageNumber = $request->get('page', 1);
            $offset = ($pageNumber - 1) * 20;
            $i = $offset;
            foreach($ordering as $order) {
                Product::withTrashed()->findOrFail($order)->update(['order' => $i]);
                $i++;
            }
            unset($i);
        }
    }

    public function forceDelete(int $productId): JsonResponse
    {
        try {
            $product = Product::with(['gallery'])
                ->withTrashed()
                ->findOrFail($productId);

            foreach($product->gallery as $image) {
                $this->deleteImage($product, $image);
                $image->delete();
            }
            $product->forceDelete();
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function restore(int $productId): JsonResponse
    {
        try {
            Product::withTrashed()->findOrFail($productId)->restore();

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
