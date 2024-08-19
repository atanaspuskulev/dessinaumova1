<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Services\TagService;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ProductsTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    use FileUploadTrait, ProductsTrait;

    public function __construct(private TagService $tagService)
    {}

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
        ->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();

        $tags = Tag::orderBy('name', 'asc')->get()->pluck('name')->toArray();

        return view('admin.products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->all());

        $this->uploadFiles($request, 'images', $product);

        cache()->forget('tags_list');

        return redirect()->route('products.edit', ['product' => $product])
            ->with('message', sprintf("Successfully created product %s", $product->title));
    }

    public function edit(int $productId): View
    {
        $product = Product::with(['gallery', 'tags'])->withTrashed()
            ->where('id', $productId)
            ->first();

        $categories = Category::all();
        $tags = Tag::orderBy('name', 'asc')->get()->pluck('name')->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * @throws \JsonException
     */
    public function update(ProductRequest $request, int $productId)
    {
        $data = $request->all();

        if(!isset($data['sold'])) {
            $data['sold'] = false;
        }

        $tags = collect();

        if(!empty($data['tags'])) {
            $requestTags = json_decode($data['tags'], true, 512, JSON_THROW_ON_ERROR);

            foreach($requestTags as $tag) {
                if(!$this->tagService->exists($tag['value'])) {
                    $newTag = $this->tagService->create(['name' => $tag['value']]);
                    $tags->push($newTag);
                } else {
                    $existingTag = $this->tagService->getOneBy(['name' => $tag['value']]);
                    $tags->push($existingTag);
                }
            }
        }

        $product = Product::withTrashed()->findOrFail($productId);

        $product->update($data);

        $product->tags()->detach();

        if(!$tags->isEmpty()) {
            $product->tags()->sync($tags->pluck('id'));
        }

        $this->uploadFiles($request, 'images', $product);

        cache()->forget('tags_list');

        return redirect()->route('products.edit', compact('product'))
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

            $this->forceDeleteProduct($product);

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
