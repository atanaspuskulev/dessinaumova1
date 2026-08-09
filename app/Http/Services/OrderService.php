<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Contracts\CleanupContractInterface;
use App\Http\Enums\OrderEnum;
use App\Http\Services\Payment\Gateway\PaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Mail\OrderCompletedToBuyer;
use App\Models\Orders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use Throwable;

class OrderService implements CleanupContractInterface
{
    public function cancelOrder(int $orderId, string $paymentOrderId): Orders
    {
        $order = Orders::find($orderId);

        if($order) {
            $order->order_id = $paymentOrderId;
            $order->status = OrderEnum::CANCELED->value;
            $order->cancelled_at = now()->toDateString();
            $order->save();
        }

        return $order;
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

    public function getPaymentGateway(string $method): PaymentGatewayInterface
    {
        return (new PaymentGateway($method))->make();
    }

    /**
     * @throws BindingResolutionException
     */
    public function makeInvoice(Orders $order): array
    {
        $items = [];

        $client = new Party([
            'name'          => 'Десислава Наумова',
        ]);

        $order->load('items');

        $customer = new Buyer([
            'name' => $order->payer_name,
            'custom_fields' => [
                'Номер на поръчка' => '> ' . $order->order_id . ' <',
                'Е-Mail адрес' => $order->payer_email,
                'Телефон' => $order->payer_phone,
                'Нас. място' => $order->payer_city,
                'Пощенски код' => $order->payer_zip,
                'Адрес' => $order->payer_address,
            ],
        ]);

        foreach($order->items as $orderItem) {
            if(!$orderItem->relationLoaded('product')) {
                $orderItem->load('product');
            }

            $items[] = InvoiceItem::make($orderItem->product->title)
                ->quantity((int) $orderItem->quantity)
                ->pricePerUnit((float)$orderItem->product->price);
        }

        $invoice = Invoice::make('фактура')
            ->name('Фактура')
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('m/d/Y')
            ->payUntilDays(5)
            ->currencyCode('лева')
            ->currencySymbol('лв')
            ->currencyFormat('{VALUE}{SYMBOL}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($order->order_id)
            ->addItems($items)
            ->notes($order->additional_information ?? 'N/a')
            ->save('invoices')
            ->logo(public_path('vendor/invoices/sample-logo.png'));

        return [
            'url' => $invoice->url(),
            'filepath' => Storage::disk('invoices')->path($invoice->filename)
        ];
    }

    public function cleanupForSession(): void
    {
        session()->forget(['cart', 'myOrder', 'delivery_method', 'payment_method']);
    }

    /**
     * Generates the invoice and emails the buyer that their order is complete.
     * The invoice must exist before the email is sent, so a failure to generate
     * it must not result in a success email with a missing attachment/link.
     */
    public function sendOrderCompletedEmail(Orders $order): void
    {
        $order->load('items.product');

        try {
            $invoice = $this->makeInvoice($order);
        } catch (Throwable $e) {
            report($e);

            return;
        }

        try {
            Mail::to($order->payer_email)->send(new OrderCompletedToBuyer($order, (string) $order->amount, $invoice));
        } catch (Throwable $e) {
            report($e);
        }
    }
}
