<?php

namespace App\Livewire;

use App\Http\Traits\CartTrait;
use Livewire\Component;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Product;

class PayPal extends Component
{
    use CartTrait;

    public function boot()
    {
        $this->checkValidCart();
    }

    public function render()
    {
        return view('livewire.checkout.payment')
            ->extends('layouts.front')
            ->section('content');
    }

    public function payment()
    {
        $cart = session()->get('cart');
        $purchaseUnits = [];

        Product::whereIn('id', $cart)->get()
            ->map(function($item) use (&$purchaseUnits) {
                $purchaseUnits[] = [
                    'amount' => [
                        'value' => $item->price,
                        'currency_code' => 'EUR'
                    ]
                ];
            });

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $paypalResponse = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('front.paypal.payment.success'),
                "cancel_url" => route('front.paypal.payment.cancel'),
            ],
            "purchase_units" => $purchaseUnits
        ]);

        if(!empty($paypalResponse['id'])) {
            $index = array_search('approve', array_column($paypalResponse['links'], 'rel'));

            if($index !== false) {
                $toPaypal = $paypalResponse['links'][$index]['href'];

                return redirect()->away($toPaypal);
            }

            return redirect()
                ->route('front.paypal.payment.cancel')
                ->with('error', 'Something went wrong.');
        }
    }
}
