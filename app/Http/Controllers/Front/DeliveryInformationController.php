<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use Illuminate\Http\Request;

class DeliveryInformationController extends Controller
{
    public function deliveryForm()
    {
        if(session()->has('delivery-information')) {
            $current = session()->get('delivery-information');

            foreach($current as $key => $data) {
                if(property_exists($this, $key)) {
                    $this->$key = $data;
                }
            }
        }

        return view('front.cart.delivery-information');
    }

    public function saveDeliveryInformation(DeliveryInformationRequest $request)
    {
        $data = $request->validated();

        session()->forget('delivery-information');

        session()->put('delivery-information', $data);


        return redirect()->to(route('front.payment'));
    }
}
