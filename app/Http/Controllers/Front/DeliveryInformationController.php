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

    public function deliveryForm(Request $request): View|RedirectResponse
    {
        $cart = session()->get('cart', false);

        $order = [];

        if($request->has('order_id')) {
            $orderId = $request->get('order_id');
            $order = Orders::find($orderId);

            if($order) {
                $cart = true;
            }
        }

        if(!$cart) {
            return redirect()->route('front.index');
        }
dd(session()->all());
        $countries = trans('countries');

        return view('front.cart.delivery-information', compact('countries', 'order'));
    }
}
