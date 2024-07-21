<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryInformationController extends Controller
{
    use CartTrait;

    public function __construct(private SessionStorageService $sessionStorageService)
    {
    }

    public function deliveryForm(Request $request): View|RedirectResponse
    {
        if($request->has('cref')) {
            $this->sessionStorageService->store('session_cref', $request->cart_reference_key);
        }

        $this->verifyCart();

        if(!$this->sessionStorageService->check('cart')) {
            return redirect(route('front.index'));
        }

        $deliveryInformation = $this->sessionStorageService->get('delivery-information');

        return view('front.cart.delivery-information', compact('deliveryInformation'));
    }

    public function saveDeliveryInformation(DeliveryInformationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->sessionStorageService->invalidate('delivery-information');
        $this->sessionStorageService->store('delivery-information', $data);

        return redirect()->to(route('front.checkout_cart_index_payment'));
    }

    private function verifyCart()
    {
        if(!$this->sessionStorageService->check('cart')) {
            return redirect()->to(route('front.index'))->send();
        }
        $this->checkCartRefererSource();
    }
}
