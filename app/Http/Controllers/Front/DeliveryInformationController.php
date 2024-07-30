<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class DeliveryInformationController extends Controller
{
    use CartTrait;

    public function __construct(private readonly SessionStorageService $sessionStorageService)
    {
    }

    public function deliveryForm(Request $request): View|RedirectResponse
    {
        if(!$this->verifyCart($request)) {
            return redirect()->to(route('front.index'));
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

    private function verifyCart(Request $request): bool
    {
        if($request->has('cart_reference_key')) {
            $this->sessionStorageService->store('cref', $request->cart_reference_key);
        }

        $cref = $this->sessionStorageService->get('cref');
        $cart = $this->sessionStorageService->check('cart');

        if($cref) {
            $cref = (int) $cref;
        }

        if($request->has('cref')) {
            $requestCref = (int) $request->cref;
        } else {
            $requestCref = $this->sessionStorageService->check('cref')
                ? (int) $this->sessionStorageService->get('cref')
                : null;
        }

        return ($cref && $requestCref) && ($cref === $requestCref) && $cart;
    }
}
