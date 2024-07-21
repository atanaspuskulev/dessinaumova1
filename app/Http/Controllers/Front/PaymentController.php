<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use App\Models\Product;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PaymentController extends Controller
{
    use CartTrait;

    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly SessionStorageService $sessionStorageService)
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws \JsonException
     */
    public function index()
    {
        if(
            !$this->sessionStorageService->check('cart')
            || !$this->sessionStorageService->check('delivery-information')
        ) {
            return redirect()->to(route('front.index'));
        }

        $cart = $this->sessionStorageService->get('cart');
        $deliveryInformation = $this->sessionStorageService->get('delivery-information');

        if(empty($cart) || empty($deliveryInformation)) {
            $this->clearCartSession();
            return redirect()->to(route('front.index'));
        }

        $paypalClientId = $this->paymentService->getPaypalClientId();
        $paypalCurrency = $this->paymentService->getPaymentConfigKey('paypal', 'currency');
        $paypalBrandName = $this->paymentService->getPaymentConfigKey('paypal', 'brand_name');
        $paypalLocale = $this->paymentService->getPaymentConfigKey('paypal', 'locale');

        $purchases = [];

        Product::whereIn('id', $cart)->get()
            ->map(static function ($item) use (&$purchases, $paypalCurrency) {
                $purchases[] = [
                    'reference_id' => $item->id,
                    'description' => $item->title,
                    'amount' => [
                        'value' => $item->price,
                        'currency_code' => $item->currency ?? $paypalCurrency
                    ]
                ];
            });

        $purchaseUnits = $this->paymentService->assemblePurchaseUnitsForPaypal($purchases, $deliveryInformation);

        $order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);

        return view('front.checkout.payment', compact('order', 'paypalClientId', 'paypalCurrency', 'paypalBrandName', 'paypalLocale', 'deliveryInformation'));
    }
}
