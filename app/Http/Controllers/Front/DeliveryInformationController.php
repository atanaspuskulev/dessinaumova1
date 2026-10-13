<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use App\Models\Orders;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class DeliveryInformationController extends Controller
{
    use CartTrait;

    public function deliveryForm(): View|RedirectResponse
    {
        $cart = session()->get('cart');

        if(!$cart) {
            return redirect()->route('front.index');
        }

        $order = new \stdClass();

        if(session()->has('myOrder')) {
            $order = Orders::findOrFail((int) session()->get('myOrder'));

            $phone = array_values(
                array_filter(trans('countries'), static fn($country) => $country['short_name'] === $order->payer_country)
            )[0] ?? null;

            $order->payer_phone = ltrim($order->payer_phone, $phone['country_code']);
            $order->setAttribute('phone_code', $phone['country_code']);
        }

        $countries = trans('countries');

        return view('front.cart.delivery-information', compact('countries', 'order'));
    }
}
