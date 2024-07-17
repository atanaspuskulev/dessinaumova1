<?php

namespace App\Http\Services;

use App\Helpers\Order;
use App\Http\Enums\OrderEnum;
use App\Http\Services\Payment\Gateway\PaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getPaymentGateway(string $gateway): PaymentGatewayInterface
    {
        return (new PaymentGateway($gateway))->make();
    }

    public function cancelOrder(int $orderId, string $paymentOrderId): void
    {
        $order = Orders::find($orderId);
        $order->order_id = $paymentOrderId;
        $order->status = OrderEnum::CANCELED->value;
        $order->cancelled_at = now()->toDateString();
        $order->save();
    }

    public function createOrderWithItems(array $orderData, array $productsIds = []): Orders
    {
        return DB::transaction(function() use ($orderData, $productsIds) {
            $order = Orders::create($orderData);

            foreach ($productsIds as $productId) {
                $order->items()->create(['product_id' => $productId]);
            }

            return $order;
        });
    }

    public function findOrderByIdAndPaymentId(int $orderId, string $paymentId): Orders
    {
        return Orders::where('id', $orderId)
            ->where('order_id', $paymentId)
            ->firstOrFail();
    }

    public function updateOrderPaymentSuccess(Orders $order, string $paymentId): Orders
    {
        $order->status = OrderEnum::COMPLETED->value;
        $order->order_id = $paymentId;
        $order->confirmed_at = now()->toDateString();
        $order->save();

        $order->load('items.product', 'items.product.category');

        return $order;
    }
}
