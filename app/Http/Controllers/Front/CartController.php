<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Http\Traits\CartTrait;
use App\Models\Product;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    use CartTrait;

    public function __construct(private readonly PriceService $priceService)
    {
    }

    public function removeFromCart(int $id): JsonResponse
    {

        $cart = session()->get('cart', []);

        if($cart) {
            $cart = array_values($cart);

            for($i = 0; $i < count($cart); $i++) {
                if($cart[$i]['product_id'] == $id) {
                    unset($cart[$i]);
                }
            }

            session()->put('cart', $cart);
        }

        $products = Product::with('thumbnail')->whereIn('id', $this->getIdsFromCart())->get();
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        foreach($cart as $cartItem) {
            $totalPrice += $cartItem['real_price'];
        }

        $totalPrice = $this->priceService->formatPrice($totalPrice, config('currencies')[App::getLocale()]);

        $html = view('front.partials.cart-list', compact('products', 'cart', 'totalPrice'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function updateQuantity(int $id): JsonResponse
    {
        $quantity = request()->get('qty');

        $cart = array_values(session()->get('cart', []));

        if($cart) {
            $cartSession = [];
            foreach($cart as $cartItem) {
                if($id == $cartItem['product_id']) {
                    $product = Product::find($cartItem['product_id']);
                    $price = $this->priceService->formatPrice($product->price * $quantity, $product->currency);

                    $item = [
                        'product_id' => $id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'real_price' => $product->price * $quantity,
                    ];

                    $cartSession[] = $item;
                } else {
                    $cartSession[] = $cartItem;
                }
            }
            session()->put('cart', $cartSession);
        }

        $products = Product::with('thumbnail')->whereIn('id', $this->getIdsFromCart())->get();
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        foreach($cart as $cartItem) {
            $totalPrice += $cartItem['real_price'];
        }

        $totalPrice = $this->priceService->formatPrice($totalPrice, config('currencies')[App::getLocale()]);

        $html = view('front.partials.cart-list', compact('products', 'cart', 'totalPrice'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
