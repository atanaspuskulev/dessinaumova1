<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Services\CartService;
use App\Http\Services\ProductsService;

class AddToCartController extends Controller
{
    public function __construct(protected ProductsService $productsService, protected CartService $cartService)
    {}

    public function __invoke(CartAddRequest $request)
    {
        $productId = (int) $request->input('product_id');

        $message = trans('cart.product_added');
        $success = $continue = true;

        if(!$this->productsService->isValidProductById($productId)) {
            $message = trans('cart.product_invalid');
            $success = $continue = false;
        } elseif($this->cartService->has($productId)) {
            $message = trans('cart.product_already_added');
            $success = $continue = false;
        } else {
            $this->cartService->add($productId);
        }

        $cart_url = route('front.cart.index');
        $cart_count = $this->cartService->getCart(true);

        return response()->json(compact('success', 'message', 'continue', 'cart_url', 'cart_count'));
    }
}
