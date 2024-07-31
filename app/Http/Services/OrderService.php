<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Helpers\Cart;
use App\Helpers\Order as OrderHelper;
use App\Http\Contracts\CleanupContractInterface;
use App\Http\Enums\OrderEnum;
use App\Http\Services\Payment\Gateway\PaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Models\Orders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class OrderService implements CleanupContractInterface
{
    public function __construct(
        private SessionStorageService $sessionStorageService,
        private CartService $cartService
    )
    {
    }

    public function getPaymentGateway(string $gateway): PaymentGatewayInterface
    {
        return (new PaymentGateway($gateway))->make();
    }

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

    public function clearOrderSession(string $key): void
    {
        $this->sessionStorageService->invalidate($key);
    }

    /**
     * @throws BindingResolutionException
     */
    public function makeInvoice(Orders $order): array
    {
        $items = [];

        $client = new Party([
            'name'          => 'Desislava Naumova',
            'phone'         => '(359) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Buyer([
            'name' => $order->payer_name,
            'custom_fields' => [
                'order number' => '> ' . OrderHelper::generateInvoiceNumber($order->id) . ' <',
                'email' => $order->payer_email,
                'phone' => $order->payer_phone,
                'country' => $order->payer_country,
                'state' => $order->payer_state,
                'city' => $order->payer_city,
                'zip' => $order->payer_zip,
                'address' => $order->payer_address,
            ],
        ]);

        foreach($order->items as $orderItem) {
            if(!$orderItem->relationLoaded('product')) {
                $orderItem->load('product');
            }

            $items[] = InvoiceItem::make($orderItem->product->title)
                ->quantity(1)
                ->pricePerUnit($orderItem->product->price);
        }

        $invoice = Invoice::make('receipt')
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('m/d/Y')
            ->payUntilDays(5)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($order->order_id)
            ->taxRate(20)
            ->addItems($items)
            ->save('invoices')
            ->logo(public_path('vendor/invoices/sample-logo.png'));

        return [
            'url' => $invoice->url(),
            'filepath' => Storage::disk('invoices')->path($invoice->filename)
        ];
    }

    public function cleanupForSession(): void
    {
        $this->cartService->cleanupForSession();
        $this->sessionStorageService->invalidate('delivery-informationjk');
    }
}
