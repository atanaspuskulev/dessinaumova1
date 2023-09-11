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
        $products = Product::with(['thumbnail', 'category'])
            ->withTrashed()
            ->get();

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

    public function reorderImages(Request $request)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->delete();
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
