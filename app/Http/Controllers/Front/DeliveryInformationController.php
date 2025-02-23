<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Services\SessionStorageService;
use App\Http\Traits\CartTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class DeliveryInformationController extends Controller
{
    use CartTrait;

    public function deliveryForm(Request $request): View|RedirectResponse
    {
        $cart = session()->get('cart');

        if(!$cart) {
            return redirect()->route('front.index');
        }

        return view('front.cart.delivery-information');
    }
}
