<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
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
        $products = Product::with(['thumbnail'])->get();

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

        return redirect()->route('products.show', ['product' => $product])
            ->with('message', sprintf("Successfully created product %s", $product->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
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

        return redirect()->route('products.show', ['product' => $product])
            ->with('message', sprintf("Successfully updated product %s", $product->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
