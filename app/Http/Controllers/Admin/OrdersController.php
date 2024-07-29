<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminViewOrderRequest;
use App\Http\Services\PriceService;
use App\Http\Services\ProductsService;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(private readonly ProductsService $productsService, private readonly PriceService $priceService)
    {

    }

    public function index(Request $request)
    {
        $orders = Orders::orderBy('updated_at', 'desc')->paginate(12);

        $orders->each(function($order) {
            $amount = $order->amount;
            $taxRate = 0.20;
            $taxAmount = $amount * $taxRate;
            $totalAmount = $amount + $taxAmount;

            $order->totalPrice = round($totalAmount, 2);
        });

        return view('admin.orders.index', compact('orders'));
    }

    public function viewOrder(AdminViewOrderRequest $request)
    {
        $validated = $request->validated();

        $order = Orders::with([
            'items',
            'items.product',
            'items.product.thumbnail'
        ])
        ->where('order_id', $validated['order_id'])
        ->where('id', $validated['id'])
        ->firstOrFail();

        $items = collect([]);
        $prices = collect([]);
        $order->items->each(function($item) use (&$items, &$prices) {
            $items->push($item->product);
            $prices->push($item->product->price);
        });

        $totalPrice = $this->priceService->calculatePrice($prices, true, 0.20);
        $priceWithoutTax = $this->priceService->calculatePrice($prices, false);

        return response()->json([
            'order' => $order,
            'items' => $this->productsService->getProductItemsWithTemplate($items),
            'priceWithoutTax' => $priceWithoutTax,
            'totalPrice' => $totalPrice,
        ]);
    }
}
