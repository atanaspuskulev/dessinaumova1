<?php

namespace App\Http\Services\Payment\Gateway\Factory;

use App\Http\Services\Payment\Gateway\AbstractPaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;

class PaypalFactory extends AbstractPaymentGateway implements PaymentGatewayInterface
{

    public function make(): PaymentGatewayInterface
    {
        return $this;
    }

    public function generateToken(): string
    {
        return 'Paypal Token';
    }
}
