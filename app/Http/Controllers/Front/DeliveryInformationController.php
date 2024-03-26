<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use App\Http\Traits\CartTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryInformationController extends Controller
{
    use CartTrait;

    public function deliveryForm(): View
    {
        if(request()->has('cref')) {
            session()->put('session_cref', request()->get('cart_reference_key'));
        }

        $this->verifyCart();
        $deliveryInformation = session()->get('delivery-information');

        return view('front.cart.delivery-information', compact('deliveryInformation'));
    }

    public function saveDeliveryInformation(DeliveryInformationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        session()->forget('delivery-information');

        session()->put('delivery-information', $data);

        return redirect()->to(route('front.payment'));
    }

    private function verifyCart()
    {
        if(!$this->checkValidCart()) {
            return redirect()->to(route('front.index'))->send();
        }
        $this->checkCartRefererSource();
    }
}
