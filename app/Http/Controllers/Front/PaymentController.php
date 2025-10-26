<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\PriceService;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use App\Models\Product;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PaymentController extends Controller
{
    use CartTrait;

    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly PriceService $priceService,
        private OrderService $orderService
    )
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws JsonException
     */
    public function index()
    {
        $orderSession = session()->get('current_order');
        $cart = session()->get('cart');

        if(!$orderSession || !$cart) {
            return redirect()->to(route('front.index'));
        }

        $paypalClientId = $this->paymentService->getPaypalClientId();
        $paypalCurrency = $this->paymentService->getPaymentConfigKey('paypal', 'currency');
        $paypalBrandName = $this->paymentService->getPaymentConfigKey('paypal', 'brand_name');
        $paypalLocale = $this->paymentService->getPaymentConfigKey('paypal', 'locale');

        $purchases = [];
        $shippingCost = 0.00;

        $pq = Product::whereIn('id', collect($cart)->pluck('product_id'))->get();
        $pq->map(static function ($item) use (&$purchases, $paypalCurrency) {
                $purchases[] = [
                    'reference_id' => $item->id,
                    'description' => $item->title,
                    'amount' => [
                        'value' => $item->price,
                        'currency_code' => $item->currency ?? $paypalCurrency
                    ]
                ];
            });

        $shippingCost = $this->priceService->calculateShippingPrice($pq->pluck('shipping_cost'));
//        dd($orderSession);
        $deliveryInformation = [
            'name' => $orderSession['payer_name'],
            'delivery_address' => $orderSession['payer_address'],
            'country' => '',
            'zip' => $orderSession['payer_zip'],
            'city' => $orderSession['payer_city'],
            'phone' => $orderSession['payer_phone'],
            'email' => $orderSession['payer_email'],
            'additional_information' => $orderSession['additional_information'],
            'state' => null
        ];

        $purchaseUnits = $this->paymentService->assemblePurchaseUnitsForPaypal($purchases, $deliveryInformation);

        $order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);

        return view('front.checkout.payment', compact(
            'order',
            'paypalClientId',
            'paypalCurrency',
            'paypalBrandName',
            'paypalLocale',
            'deliveryInformation',
            'shippingCost'
        ));
    }
}
