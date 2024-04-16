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

    }
}
