<?php

namespace App\Livewire;

use App\Helpers\CountriesHelper;
use Livewire\Component;

class Checkout extends Component
{
    public function render()
    {
        return view('livewire.checkout');
    }

    public function deliveryInformation()
    {
        return view('livewire.checkout.delivery-information');
    }
}
