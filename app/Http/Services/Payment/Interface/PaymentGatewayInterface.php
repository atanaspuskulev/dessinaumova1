<?php

namespace App\Http\Services\Payment\Interface;

interface PaymentGatewayInterface
{
    public function make(): self;

    public function getAuthToken(bool $refreshToken = false): string;

    public function createOrder();
}
