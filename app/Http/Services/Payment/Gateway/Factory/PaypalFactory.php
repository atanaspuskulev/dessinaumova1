<?php

namespace App\Http\Services\Payment\Gateway\Factory;

use App\Http\Services\Payment\Gateway\AbstractPaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Http;

class PaypalFactory extends AbstractPaymentGateway implements PaymentGatewayInterface
{
    private bool $isSandbox = true;
    private string|null $accessToken = null;

    public function make(): PaymentGatewayInterface
    {
        $this->isSandbox = config('paypal.mode') === 'sandbox';
        return $this;
    }

    public function getAuthToken(bool $refreshToken = false): string
    {
        if($refreshToken) {
            $this->accessToken = null;
        }

        if($this->accessToken) {
            return $this->accessToken;
        }

        $clientId = $this->isSandbox ? config('paypal.sandbox.client_id') : config('paypal.live.client_id');
        $clientSecret = $this->isSandbox ? config('paypal.sandbox.client_secret') : config('paypal.live.client_secret');
        $authApiUrl = $this->isSandbox ? config('paypal.sandbox.access_token_url') : config('paypal.live.access_token_url');
        $baseAuth = base64_encode($clientId . ':' . $clientSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $baseAuth,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])
        ->asForm()
        ->post($authApiUrl, [
            'grant_type' => 'client_credentials'
        ]);

        if($response->failed()) {
            $responseBody = $response->json();
            throw new RuntimeException(
                sprintf(
                    'Failed to generate Access Token: %s; %s',
                    $responseBody['error'], $responseBody['error_description']
                )
            );
        }

        $authResponse = $response->json();

        $this->accessToken = $authResponse['access_token'] ?? '';

        return $this->accessToken;
    }
}
