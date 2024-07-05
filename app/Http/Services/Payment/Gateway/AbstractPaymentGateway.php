<?php

namespace App\Http\Services\Payment\Gateway;

use App\Http\Services\Payment\Interface\PaymentGatewayInterface;

abstract class AbstractPaymentGateway
{
    abstract public function make(): PaymentGatewayInterface;
}
