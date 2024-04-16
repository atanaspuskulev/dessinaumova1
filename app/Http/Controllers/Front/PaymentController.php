<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Traits\CartTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PaymentController extends Controller
{
    use CartTrait;

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws \JsonException
     */
    public function index()
    {
        if(!$this->checkValidCart() || !$this->checkDeliveryAddress()) {
            return redirect()->to(route('front.index'));
        }

        $paypalClientId = config('paypal.mode') === 'sandbox'
            ? config('paypal.sandbox.client_id')
            : config('paypal.live.client_id');

        $paypalCurrency = config('paypal.currency');
        $paypalBrandName = config('paypal.brand_name');
        $paypalLocale = config('paypal.locale');

        $cart = session()->get('cart');
        $deliveryInformation = session()->get('delivery-information');

        if(empty($cart) || empty($deliveryInformation)) {
            $this->clearCartSession();
            return redirect()->to(route('front.index'));
        }

        $purchaseUnits = [];

        Product::whereIn('id', $cart)->get()
            ->map(static function ($item) use (&$purchaseUnits) {
                $purchaseUnits[] = [
                    'reference_id' => $item->id,
                    'description' => $item->title,
                    'amount' => [
                        'value' => $item->price,
                        'currency_code' => 'EUR'
                    ]
                ];
            });

        $purchaseUnits = [
            'purchase_units' => $purchaseUnits
        ];

        $purchaseUnits['shipping']['name']['full_name'] = $deliveryInformation['name'];
        $purchaseUnits['shipping']['address'] = [
            'address_line_1' => $deliveryInformation['delivery_address'],
            'country_code' => $deliveryInformation['country'],
            'postal_code' => $deliveryInformation['zip'],
            'admin_area_1' => $deliveryInformation['state'],
            'admin_area_2' => $deliveryInformation['city']
        ];

        $purchaseUnits['payer']['email_address'] = $deliveryInformation['email'];
        $purchaseUnits['payer']['phone']['phone_number']['national_number'] = $deliveryInformation['phone'];

        $purchaseUnits['merchant_preferences'] = [
            'note_to_merchant' => !empty($deliveryInformation['additional_information'])
                ? strip_tags(htmlentities($deliveryInformation['additional_information']))
                : ''
        ];

        $order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);

        return view('front.checkout.payment', compact('order', 'paypalClientId', 'paypalCurrency', 'paypalBrandName', 'paypalLocale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
