<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Enums\DeliveryMethodEnum;
use App\Http\Enums\OrderEnum;
use App\Http\Services\OrderService;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\PriceService;
use App\Models\Orders;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use RuntimeException;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly PriceService $priceService,
        private readonly OrderService $orderService
    )
    {
    }

    public function paymentChoose(Request $request)
    {
        $order = Orders::with('items')->find((int) session()->get('myOrder'));

        if(empty($order) || $order->items->isEmpty()) {
            return redirect()->route('front.index');
        }

        if($request->isMethod('POST')) {
            $deliveryMethod = DeliveryMethodEnum::tryFrom((string) $request->get('order_by'));

            if($deliveryMethod === null) {
                return redirect()->back();
            }

            $order->update(['delivery_method' => $deliveryMethod->value]);
            session()->put('delivery_method', $deliveryMethod->value);

            return redirect()->route('front.payment_method_choose');
        }

        $deliveryMethod = session('delivery_method', $order->delivery_method);

        $payerCountry = array_values(
            array_filter(trans('countries'), static fn($country) => $country['short_name'] === $order->payer_country)
        )[0] ?? null;

        $addressArray = [
            trans('cart.payer_country') => $payerCountry['name'],
            trans('cart.payer_zip') => $order['payer_zip'],
            trans('cart.payer_city') => $order['payer_city'],
            trans('cart.payer_address') => $order['payer_address'],
            trans('cart.payer_name') => $order['payer_name'],
            trans('cart.payer_email') => $order['payer_email'],
            trans('cart.payer_phone') => $order['payer_phone'],
            trans('cart.information') => $order['additional_information'] ?? 'N/A',
        ];

        return view('front.checkout.payment-and-delivery', compact('addressArray', 'order', 'deliveryMethod'));
    }

    public function paymentMethodChoose(Request $request)
    {
        $order = Orders::with('items')->find((int) session()->get('myOrder'));

        if(empty($order) || $order->items->isEmpty() || !session()->has('delivery_method')) {
            return redirect()->route('front.index');
        }

        if($request->isMethod('POST')) {
            $request->validate(['payment_method' => 'required|in:cod,paypal']);

            $paymentMethod = $request->get('payment_method');

            $order->update(['payment_method' => $paymentMethod]);
            session()->put('payment_method', $paymentMethod);

            if($paymentMethod === 'cod') {
                $order->update([
                    'status' => OrderEnum::COMPLETED->value,
                    'confirmed_at' => now()->toDateString(),
                ]);

                $this->orderService->sendOrderCompletedEmail($order);

                $this->orderService->cleanupForSession();

                return redirect()->route('front.order_completed');
            }

            return redirect()->route('front.payment');
        }

        $paymentMethod = session('payment_method');

        return view('front.checkout.payment-method', compact('paymentMethod'));
    }

    /**
     * @throws JsonException
     */
    public function payment()
    {
        $order = Orders::with('items.product')->find((int) session()->get('myOrder'));

        if(empty($order) || $order->items->isEmpty() || session('payment_method') !== 'paypal') {
            return redirect()->route('front.payment_method_choose');
        }

        $paypalClientId = $this->paymentService->getPaypalClientId();
        $paypalCurrency = $this->paymentService->getPaymentConfigKey('paypal', 'currency');
        $paypalBrandName = $this->paymentService->getPaymentConfigKey('paypal', 'brand_name');
        $paypalLocale = $this->paymentService->getPaymentConfigKey('paypal', 'locale');

        $purchases = $this->assemblePurchasesFromOrder($order, $paypalCurrency);

        $shippingCost = $this->priceService->calculateShippingPrice($order->items->pluck('product.shipping_cost'));

        $deliveryInformation = $this->assembleDeliveryInformationFromOrder($order);

        $purchaseUnits = $this->paymentService->assemblePurchaseUnitsForPaypal($purchases, $deliveryInformation);

        $order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);

        return view('front.checkout.payment', compact(
            'order',
            'paypalClientId',
            'paypalCurrency',
            'paypalBrandName',
            'paypalLocale',
            'shippingCost'
        ));
    }

    public function createPaypalOrder(): JsonResponse
    {
        $order = Orders::with('items.product')->find((int) session()->get('myOrder'));

        if(empty($order) || $order->items->isEmpty() || session('payment_method') !== 'paypal') {
            return response()->json(['status' => false, 'message' => 'Invalid order.'], 422);
        }

        $paypalCurrency = $this->paymentService->getPaymentConfigKey('paypal', 'currency');
        $purchases = $this->assemblePurchasesFromOrder($order, $paypalCurrency);

        try {
            $gateway = $this->orderService->getPaymentGateway('paypal');
            $accessToken = $gateway->getAuthToken();

            $paypalOrder = $gateway->createOrder(['purchase_units' => $purchases], $accessToken);

            $order->update(['order_id' => $paypalOrder['id']]);

            return response()->json(['status' => true, 'data' => $paypalOrder]);
        } catch(RuntimeException $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function capturePaypalOrder(Request $request): JsonResponse
    {
        $order = Orders::find((int) session()->get('myOrder'));

        if(empty($order) || session('payment_method') !== 'paypal') {
            return response()->json(['status' => false, 'message' => 'Invalid order.'], 422);
        }

        try {
            $currentOrder = $this->orderService->findOrderByIdAndPaymentId($order->id, (string) $request->get('orderId'));

            $gateway = $this->orderService->getPaymentGateway('paypal');
            $accessToken = $gateway->getAuthToken();

            $payResult = $gateway->captureAndPay(['orderId' => $request->get('orderId')], $accessToken);

            if(isset($payResult['status']) && $payResult['status'] === 'COMPLETED') {
                $completedOrder = $this->orderService->updateOrderPaymentSuccess($currentOrder, $payResult['id']);

                $this->orderService->sendOrderCompletedEmail($completedOrder);

                $this->orderService->cleanupForSession();

                return response()->json($payResult, 200);
            }

            return response()->json($payResult, 417);
        } catch(RuntimeException $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 417);
        }
    }

    public function cancelPaypal(Request $request)
    {
        $orderId = session()->get('myOrder');

        if($orderId && session('payment_method') === 'paypal') {
            $order = Orders::find($orderId);

            if($order && $order->status === OrderEnum::PENDING->value) {
                $this->orderService->cancelOrder($orderId, (string) $request->get('orderID'));
            }
        }

        $this->orderService->cleanupForSession();

        return view('front.orders.cancel');
    }

    private function assemblePurchasesFromOrder(Orders $order, string $paypalCurrency): array
    {
        $purchases = [];

        foreach($order->items as $item) {
            $purchases[] = [
                'reference_id' => (string) $item->product_id,
                'description' => $item->product->title,
                'amount' => [
                    'value' => $this->paymentService->convertBgnToEur((float) $item->price),
                    'currency_code' => $paypalCurrency,
                ],
            ];
        }

        return $purchases;
    }

    private function assembleDeliveryInformationFromOrder(Orders $order): array
    {
        return [
            'name' => $order->payer_name,
            'delivery_address' => $order->payer_address,
            'country' => $order->payer_country,
            'zip' => $order->payer_zip,
            'state' => $order->payer_city,
            'city' => $order->payer_city,
            'email' => $order->payer_email,
            'phone' => $order->payer_phone,
            'additional_information' => $order->additional_information,
        ];
    }
}
