<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Http\Traits\CartTrait;
use App\Models\Product;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Payment extends Component
{
    use CartTrait;

    public string $order;
    public string $paypalClientId = '';
    public string $paypalBrandName = '';
    public string $paypalCurrency = '';
    public string $paypalLocale = '';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \JsonException
     */
    public function mount()
    {
        $this->cartToJson();
    }

    public function booted()
    {
        $this->checkValidCart();
        $this->checkDeliveryAddress();
        $this->paypalClientId = config('paypal.mode') === 'sandbox'
            ? config('paypal.sandbox.client_id')
            : config('paypal.live.client_id');

        $this->paypalCurrency = config('paypal.currency');
        $this->paypalBrandName = config('paypal.brand_name');
        $this->paypalLocale = config('paypal.locale');
    }

    public function render()
    {
        return view('livewire.checkout.payment')
            ->extends('layouts.front')
            ->section('content');
    }

    private function cartToJson()
    {
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

        // Initialize purchase_units as an array
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

        $this->order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);
    }
}
