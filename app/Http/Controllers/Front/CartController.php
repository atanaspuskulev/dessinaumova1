<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Services\SessionStorageService;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function removeFromCart(Request $request): JsonResponse
    {
        $productId = (int) $request->input('productId');

        $cartService = new CartService(new SessionStorageService(), new ProductsService(), new PriceService());

        if(!$cartService->remove($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart',
            ]);
        }

        $data = $cartService->getCartPreviewData(new Category());

        $html = view('front.partials.cart-list', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
