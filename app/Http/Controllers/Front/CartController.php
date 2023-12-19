<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0.00;

        $products = Product::with([
            'category',
            'thumbnail'
        ])->whereIn('id', $cart)
        ->get()
        ->each(static function($product) use (&$totalPrice) {
            $totalPrice += $product->price;
        });

        $categories = null;
        if(!$products->count()) {
            $categories = Category::all();
        }

        if(!session()->has('cref')) {
            session()->put('cref', time());
        }

        $cref = session()->get('cref');

        return view('front.cart.index', compact('cref', 'products', 'totalPrice', 'categories'));
    }
    public function store(CartAddRequest $request): JsonResponse
    {
        $cart = session()->get('cart');
        $productId = (int) $request->input('product_id');

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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function removeFromCart(Request $request): JsonResponse
    {
        $productId = (int) $request->input('productId');

        if(!$this->_verifyProduct($productId)) {
            return response()->json(['success' => false]);
        }

        $cart = session()->get('cart', []);

        $searchIndex = array_search($productId, $cart);

        if($searchIndex !== false) {
            unset($cart[$searchIndex]);

            $cart = array_values($cart);
            session()->put('cart', $cart);
        }

        $cart = session()->get('cart', []);
        $price = 0.00;

        if(!empty($cart)) {
            Product::whereIn('id', $cart)
                ->get()
                ->map(static function($record) use (&$price) {
                    $price += $record->price;
                });
        }

        return response()->json(['success' => true, 'total_price' => $price]);
    }

    private function _verifyProduct(int $productId): bool
    {
        return (bool) Product::find($productId);
    }
}
