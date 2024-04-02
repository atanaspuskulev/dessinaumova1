<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Traits\CartTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use CartTrait;

    private string $paypalClientId;
    private string $paypalCurrency;
    private string $paypalBrandName;
    private string $paypalLocale;

    public function index()
    {
        if(!$this->checkValidCart() || !$this->checkDeliveryAddress()) {
            return redirect()->to(route('front.index'));
        }

        $this->paypalClientId = config('paypal.mode') === 'sandbox'
            ? config('paypal.sandbox.client_id')
            : config('paypal.live.client_id');

        $this->paypalCurrency = config('paypal.currency');
        $this->paypalBrandName = config('paypal.brand_name');
        $this->paypalLocale = config('paypal.locale');
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
