<?php

namespace App\Http\Services\Payment\Gateway;

use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use Illuminate\Support\Str;

class PaymentGateway
{
    public function __construct(private string $requestGateway)
    {}

    public function make(): PaymentGatewayInterface
    {
        $factoryClass = '\\App\\Http\\Services\\Payment\\Gateway\\Factory\\' . Str::ucfirst(Str::lower($this->requestGateway)) . 'Factory';

        return (new $factoryClass)->make();
    }
}
