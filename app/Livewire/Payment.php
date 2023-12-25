<?php

namespace App\Livewire;

use Livewire\Component;

class Payment extends Component
{
    public function render()
    {
        return view('livewire.checkout.payment')
            ->extends('layouts.front')
            ->section('content');
    }
}
