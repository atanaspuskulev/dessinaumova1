<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Traits\CartTrait;

class AddToCartController extends Controller
{
    use CartTrait;

    public function __construct(private readonly ProductsService $productsService, private readonly PriceService $priceService)
    {
    }

    public function store(CartAddRequest $request)
    {
        $data = $request->validated();

        $quantity = $data['quantity'];
        $product = $this->productsService->getByIds([$data['product_id']])->first();

        abort_if(!$product, 404);

        $price = $this->priceService->formatPrice($product->price * $quantity, $product->currency);

        $cartIds = $this->getIdsFromCart();

        $sessionData = [];

        if(empty($cartIds)) {
            $sessionData[] = [
                'product_id' => $data['product_id'],
                'quantity' => $quantity,
                'price' => $price,
                'real_price' => $product->price,
            ];
        } else {
            $cartSession = session()->get('cart');
            foreach($cartSession as $cartItem) {
                if($cartItem['product_id'] == $data['product_id']) {
                    $newQty = $cartItem['quantity'] + $quantity;
                    $price = $this->priceService->formatPrice($product->price * $newQty, $product->currency);
                    $sessionData[] = [
                        'product_id' => $data['product_id'],
                        'quantity' => $newQty,
                        'price' => $price,
                        'real_price' => $product->price + $cartItem['real_price'],
                    ];
                } else {
                    $cartSession[] = [
                        'product_id' => $data['product_id'],
                        'quantity' => $quantity,
                        'price' => $price,
                        'real_price' => $product->price,
                    ];
                }
            }
            $sessionData = $cartSession;
        }

        session()->put('cart', $sessionData);

        return redirect()->route('front.cart.index');
    }
}
