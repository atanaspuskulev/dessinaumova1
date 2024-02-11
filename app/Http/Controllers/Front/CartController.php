<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Services\ProductsService;
use App\Http\Traits\CartTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{

   // use CartTrait;

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

        $cart = session()->get('cart');
        $price = 0.00;

        if($cart !== null) {
            $price = $this->calculateCartAmount($cart);
        } else {
            $this->clearCrefKeys();
        }

        return response()->json([
            'success' => true,
            'total_price' => $price,
            'total_products' => count($cart)
        ]);
    }

    private function _verifyProduct(int $productId): bool
    {
        return (bool) Product::find($productId);
    }
}
