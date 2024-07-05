<?php

namespace App\Http\Services;

use App\Http\Services\Payment\Gateway\PaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;

class OrderService
{
    public function getPaymentGateway(string $gateway): PaymentGatewayInterface
    {
        return (new PaymentGateway($gateway))->make();
    }
}
