<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Http\RedirectResponse;
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

    protected $rules = [
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'zip' => 'required',
        'delivery_address' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable|numeric',
        'additional_information' => 'nullable|string',
    ];

    public function render(): View
    {
        return view('livewire.checkout.delivery-information')
            ->extends('layouts.front')
            ->section('content');
    }


    public function saveDeliveryInformation(): RedirectResponse
    {
        $data = $this->validate();

        session()->forget('delivery-information');

        session()->put('delivery-information', $data);

        $this->resetFormFields();

        return redirect()->to('front.payment');
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
