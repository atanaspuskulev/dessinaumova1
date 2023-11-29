<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class CartController extends Controller
{

    public function index(): View
    {
        die;
    }
    public function store(CartAddRequest $request): JsonResponse
    {
        $cart = session()->get('cart');
        $productId = $request->input('product_id');

        if(!$this->_verifyProduct($productId)) {
            return response()->json(['success' => false, 'message' => 'This product is not valid.']);
        }

        $message = 'Product was added to the cart.';
        $showContinueBrowsingButton = true;
        $cartCount = 0;

        if(!$cart) {
            session()->put('cart', [$productId]);
            $cartCount = 1;
        } else {
            if(!in_array($productId, $cart, true)) {
                $cart[] = $productId;
                session()->put('cart', $cart);
            } else {
                $message = 'This product is already in your cart.';
                $showContinueBrowsingButton = false;
            }
            $cartCount = count($cart);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'continue' => $showContinueBrowsingButton,
            'cart_url' => route('front.cart.index'),
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function _verifyProduct(int $productId): bool
    {
        return (bool) Product::find($productId);
    }
}
