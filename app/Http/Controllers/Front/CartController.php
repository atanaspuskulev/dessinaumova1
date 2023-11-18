<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CartAddRequest $request): JsonResponse
    {
        $cart = session()->get('cart');
        $productId = $request->input('product_id');

        if(!$this->_verifyProduct($productId)) {
            return response()->json(['success' => false, 'message' => 'This product is not valid.']);
        }

        if(!$cart) {
            session()->put('cart', [$productId]);
        } else if(!in_array($productId, $cart, true)) {
            $cart[] = $productId;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true, 'message' => 'Product added to the cart.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    private function _verifyProduct($productId): bool
    {
        return (bool) Product::find($productId);
    }
}
