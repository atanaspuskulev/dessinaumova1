<?php

namespace App\Http\Services\Payment\Gateway\Factory;

use App\Http\Services\Payment\Gateway\AbstractPaymentGateway;
use App\Http\Services\Payment\Interface\PaymentGatewayInterface;
use App\Http\Traits\CartTrait;
use http\Exception\InvalidArgumentException;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Http;

class PaypalFactory extends AbstractPaymentGateway implements PaymentGatewayInterface
{
    use CartTrait;

    private bool $isSandbox = true;

    public function make(): PaymentGatewayInterface
    {
        $this->isSandbox = config('paypal.mode') === 'sandbox';
        return $this;
    }

    public function getAuthToken(bool $refreshToken = false): string
    {
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

        return $authResponse['access_token'] ?? '';
    }

    public function createOrder(array $orderInfo, #[\SensitiveParameter] string|null $accessToken = null)
    {
        $purchaseUnits = [];

        $this->getProductsFromCart()->each(static function($product) use (&$purchaseUnits) {
            $purchaseUnits[] = [
                'custom_id' => $product->id,
                'description' => $product->short_description,
                'amount' => [
                    'currency_code' => config('paypal.currency'),
                    'value' => $product->price
                ],
            ];
        });

        $paypalApi = $this->isSandbox ? config('paypal.sandbox.paypal_api_url') : config('paypal.live.paypal_api_url');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($paypalApi . '/orders/', [
                'intent' => 'CAPTURE',
                'purchase_units' => $purchaseUnits
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \RuntimeException('Failed to create Order (' . $response->status() . '): ' . $response->body());
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
