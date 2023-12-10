<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class CheckoutDelivery extends Component
{
    public string $country = '';
    public string $state = '';
    public string $city = '';
    public string $zip = '';
    public string $delivery_address = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $additional_information = '';

    public function render(): View
    {
        return view('livewire.checkout.delivery-information')
            ->extends('layouts.front')
            ->section('content');
    }

    public function saveDeliveryInformation()
    {
        dd("DD");

        $this->resetFormFields();
    }

    private function resetFormFields(): void
    {
        $this->reset([
            'country',
            'state',
            'city',
            'zip',
            'delivery_address',
            'name',
            'email',
            'phone',
            'additional_information',
        ]);
    }
}
