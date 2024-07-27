<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminViewOrderRequest;
use App\Http\Services\ProductsService;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(private readonly ProductsService $productsService)
    {

    }

    public function index(Request $request)
    {
        $orders = Orders::orderBy('updated_at', 'desc')->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function viewOrder(AdminViewOrderRequest $request)
    {
        $validated = $request->validated();

        $order = Orders::with([
            'items',
            'items.product'
        ])
        ->where('order_id', $validated['order_id'])
        ->where('id', $validated['id'])
        ->firstOrFail();

        $items = collect([]);
        $order->items->each(function($item) use (&$items) {
           $items->push($item->product);
        });

        return response()->json([
            'order' => $order,
            'items' => $this->productsService->getProductItemsWithTemplate($items)
        ]);
    }
}
