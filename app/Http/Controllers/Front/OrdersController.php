<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Traits\CartTrait;
use App\Mail\OrderCreatedToBuyer;
use App\Mail\OrderCreatedToSeller;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Throwable;


class OrdersController extends Controller
{
    use CartTrait;

    public function createOrder(OrderRequest $request)
    {
        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('front.index');
        }

        $data = $request->validated();

        $data['status'] = 'Pending';

        $data['order_id'] = $this->generateOrderNumber();
        $data['order_num'] = $this->getLastOrderNum();

        $data['amount'] = 0;

        foreach($cart as $item) {
            $data['amount'] += $item['real_price'];
        }

        $data['currency'] = 'EUR';

        $order = Orders::create($data);

        $totalPrice = 0;
        foreach($cart as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $item['quantity'] * $product->price;

            if(!$product->has_qty) {
                $product->update(['sold' => true]);
            }

            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['real_price'],
                'currency' => 'EUR',
            ]);
        }

        $order->load(['items', 'items.product', 'items.product.category']);

        try {
            Mail::to($order->payer_email)->send(new OrderCreatedToBuyer($order, (string) $totalPrice));
        } catch (Throwable $e) {
            report($e);
        }

        try {
            Mail::to(config('mail.to_admin_email'))->send(new OrderCreatedToSeller($order));
        } catch (Throwable $e) {
            report($e);
        }

        session()->put('myOrder', $order->id);

        return redirect()->route('front.payment_and_delivery');
    }

    public function completed()
    {
        return view('front.orders.complete');
    }
}
