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
}
