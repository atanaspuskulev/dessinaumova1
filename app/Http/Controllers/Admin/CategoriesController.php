<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ProductsTrait;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    use FileUploadTrait, ProductsTrait;

    public function index()
    {
        $categories = Category::withTrashed()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->all());

        cache()->forget('cached_categories');

        $this->uploadFiles($request, 'image', $category, 'categories', 'thumbnail');

        return redirect()->route('categories.edit', compact('category'))
            ->with('message', sprintf("Successfully updated category %s", $category->title));
    }

    public function edit(int $categoryId): View
    {
        $category = Category::with('thumbnail')->withTrashed()
            ->findOrFail($categoryId);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, int $categoryId)
    {
        $data = $request->all();

        $data['is_active'] = isset($data['is_active']);

        $category = Category::withTrashed()
            ->findOrFail($categoryId);

        $category->update($data);

        cache()->forget('cached_categories');

        if($category->thumbnail !== null && $request->hasFile('image')) {
            $this->deleteImage($category, $category->thumbnail, 'categories');
            $category->thumbnail->delete();
        }

        $this->uploadFiles($request, 'image', $category, 'categories', 'thumbnail');

        return redirect()->route('categories.edit', compact('category'))
            ->with('message', sprintf("Successfully updated category %s", $category->title));
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            cache()->forget('cached_categories');
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function forceDelete(int $categoryId): JsonResponse
    {
        try {
            $category = Category::with(['products', 'products.gallery'])
                ->withTrashed()
                ->findOrFail($categoryId);

            foreach($category->products as $product) {
                $this->forceDeleteProduct($product);
            }

            $category->forceDelete();
            cache()->forget('cached_categories');
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function restore(int $categoryId): JsonResponse
    {
        try {
            Category::withTrashed()->findOrFail($categoryId)->restore();
            cache()->forget('cached_categories');
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
