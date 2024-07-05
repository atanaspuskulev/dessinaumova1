<?php

namespace App\Http\Services\Payment\Interface;

interface PaymentGatewayInterface
{
    public function make(): self;
}
