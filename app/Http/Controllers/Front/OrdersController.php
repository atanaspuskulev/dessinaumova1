<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CountriesHelper;
use App\Http\Controllers\Controller;
use App\Http\Enums\OrderEnum;
use App\Http\Services\OrderService;
use App\Http\Traits\CartTrait;
use App\Mail\OrderCompletedToBuyer;
use App\Mail\OrderCreatedToBuyer;
use App\Mail\OrderCreatedToSeller;
use App\Models\Orders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use LaravelDaily\Invoices\Classes\Party;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Helpers\Order as OrderHelper;

class OrdersController extends Controller
{
    use CartTrait;

    public function __construct(protected OrderService $orderService)
    {}

    public function captureAndComplete(): View
    {
        return view('front.orders.complete');
    }

    public function captureAndCancel(): View
    {
        return view('front.orders.cancel');
    }

    public function cancelOrder(Request $request): JsonResponse
    {
        if ($request->has('orderID') && session()->has('current_payment_order_id')) {
            $order = Orders::find(session()->get('current_payment_order_id'));
            $order->order_id = $request->orderID;
            $order->status = OrderEnum::CANCELED->value;
            $order->cancelled_at = now()->toDateString();
            $order->save();
        }

        $this->clearCartSession();

        return response()->json([]);
    }

    public function createOrder(Request $request): JsonResponse
    {
        $status = true;

//        if (session()->has('current_payment_order_id')) {
//            return response()->json(compact('status'));
//        }

        try {
            $productsIds = [];
            $prices = collect();

            $requestOrder = $request['order'];

            foreach ($requestOrder['purchase_units'] as $unit) {
                $productsIds[] = $unit['reference_id'];
                $prices->push($unit['amount']['value']);
            }

            $orderData = [
                'order_id' => '',
                'status' => OrderEnum::PENDING->value,
                'amount' => $this->calculateCartAmount($prices),
                'currency' => config('paypal.currency'),
                'payer_name' => $requestOrder['shipping']['name']['full_name'],
                'payer_email' => $requestOrder['payer']['email_address'],
                'payer_phone' => $requestOrder['payer']['phone']['phone_number']['national_number'],
                'payer_country' => CountriesHelper::getCountryNameByCode($requestOrder['shipping']['address']['country_code']),
                'payer_country_code' => $requestOrder['shipping']['address']['country_code'],
                'payer_state' => $requestOrder['shipping']['address']['admin_area_1'],
                'payer_city' => $requestOrder['shipping']['address']['admin_area_2'],
                'payer_zip' => $requestOrder['shipping']['address']['postal_code'],
                'payer_address' => $requestOrder['shipping']['address']['address_line_1'],
                'additional_information' => $requestOrder['merchant_preferences']['note_to_merchant']
            ];

            $this->orderService->getPaymentGateway($request->paymentMethod);

            $order = Orders::create($orderData);

            foreach ($productsIds as $productId) {
                $order->items()->create(['product_id' => $productId]);
            }

            session()->put('current_payment_order_id', $order->id);

            Mail::to($orderData['payer_email'])->queue(new OrderCreatedToBuyer());
            Mail::to($requestOrder['payer']['email_address'])->queue(new OrderCreatedToBuyer());
        } catch (\Exception $e) {
            $message = sprintf(
                'An error occurred while trying to create user order and send email: %s',
                $e->getMessage()
            );

            Log::emergency($message);

            $status = false;
        }

        return response()->json(compact('status'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateOrder(Request $request)
    {die("DA");
        $status = 417;

        if (session()->has('current_payment_order_id') && $request->get('intent') === 'CAPTURE' && $request->get('status') === 'COMPLETED') {

            $currentOrder = Orders::where('order_id', $request->id)
                ->where('id', session()->get('current_payment_order_id'))
                ->firstOrFail();

//            if($currentOrder->status === OrderEnum::COMPLETED->value) {
//                return response()->json([], 417);
//            }

            $currentOrder->status = OrderEnum::COMPLETED->value;
            $currentOrder->order_id = $request['id'];
            $currentOrder->confirmed_at = now()->toDateString();
            $currentOrder->save();
            $status = 200;

            $order = Orders::with([
                'items.product',
                'items.product.category'
            ])->findOrFail($currentOrder->id);

            Mail::to(config('mail.to_admin_email'))->queue(new OrderCreatedToSeller($order));
        }

        $this->clearCartSession();

        return response()->json([], $status);
    }

    public function test()
    {

        $order = Orders::with('items.product', 'items.product.category')->latest()->first();
        $this->makeInvoice($order);
        return new OrderCompletedToBuyer($order);

    }

    /**
     * @throws BindingResolutionException
     */
    public function makeInvoice($order)
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
dd($invoice->url());
        return $invoice->url();
    }
}
