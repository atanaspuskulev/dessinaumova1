<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Traits\CartTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    use CartTrait;

    public function __construct(private readonly CartService $cartService, private readonly ProductsService $productsService, private readonly PriceService $priceService)
    {}

    public function index(): View
    {
        $products = $this->getProductsFromCart(true, ['category', 'thumbnail']);

        $totalPrice = $this->calculateCartAmount($products->pluck('price'), true);
        $priceWithoutTax = $this->calculateCartAmount($products->pluck('price'), false);

        $taxAmount = $totalPrice - $priceWithoutTax;

        $categories = null;

        if(!$products->count()) {
            $categories = Category::all();
        }

        if(!session()->has('cref')) {
            session()->put('cref', time());
        }

        $cref = session()->get('cref');

        return view('front.cart.index', compact('cref', 'products', 'totalPrice', 'categories', 'taxAmount'));
    }

    public function removeFromCart(Request $request): JsonResponse
    {
        $productId = (int) $request->input('productId');

        if(!$this->cartService->remove($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart',
            ]);
        }

        $data = $this->getCartPreviewData($this->cartService, $this->productsService, $this->priceService);

        $html = view('front.partials.cart-list', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    private function _verifyProduct(int $productId): bool
    {
        return Product::find($productId);
    }
}
