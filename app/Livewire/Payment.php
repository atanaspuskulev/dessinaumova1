<?php

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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
    }

    public function render()
    {
        return view('livewire.checkout.payment')
            ->extends('layouts.front')
            ->section('content');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \JsonException
     */
    private function cartToJson(): void
    {
        $cart = session()->get('cart');
        $deliveryAddress = session()->get('delivery-address');

        $purchaseUnits = [];

        Product::whereIn('id', $cart)->get()
            ->map(static function($item) use (&$purchaseUnits) {
                $purchaseUnits[] = [
                    'description' => $item->title,
                    'amount' => [
                        'value' => $item->price,
                        'currency_code' => 'EUR'
                    ]
                ];
            });

//        $purchaseUnits['shipping']['name']['full_name'] => $deliveryAddress

        $this->order = json_encode($purchaseUnits, JSON_THROW_ON_ERROR);
    }
}
