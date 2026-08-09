<?php

namespace App\Http\Services\Payment;

class PaymentService
{
    /**
     * Fixed BGN/EUR currency board peg (Bulgarian National Bank, unchanged since 1997).
     * PayPal does not support BGN as a transaction currency, so amounts are converted
     * to EUR using this fixed rate rather than a floating exchange rate.
     */
    private const BGN_TO_EUR_RATE = 1.95583;

    public function convertBgnToEur(float $amountInBgn): float
    {
        return round($amountInBgn / self::BGN_TO_EUR_RATE, 2);
    }

    public function getPaypalClientId(): string|null
    {
        return config('paypal.mode') === 'sandbox'
            ? config('paypal.sandbox.client_id')
            : config('paypal.live.client_id');
    }

    public function getPaymentConfigKey(string $paymentMethod, string $configKey): string|null
    {
        return config(sprintf("%s.%s", $paymentMethod, $configKey));
    }

    public function assemblePurchaseUnitsForPaypal(array $purchases, array $deliveryInformation): array
    {
        $purchaseUnits = [
            'purchase_units' => $purchases
        ];

        $purchaseUnits['shipping']['name']['full_name'] = $deliveryInformation['name'];
        $purchaseUnits['shipping']['address'] = [
            'address_line_1' => $deliveryInformation['delivery_address'],
            'country_code' => $deliveryInformation['country'],
            'postal_code' => $deliveryInformation['zip'],
            'admin_area_1' => $deliveryInformation['state'],
            'admin_area_2' => $deliveryInformation['city']
        ];

        $purchaseUnits['payer']['email_address'] = $deliveryInformation['email'];
        $purchaseUnits['payer']['phone']['phone_number']['national_number'] = $deliveryInformation['phone'];

        $purchaseUnits['merchant_preferences'] = [
            'note_to_merchant' => !empty($deliveryInformation['additional_information'])
                ? strip_tags(htmlentities($deliveryInformation['additional_information']))
                : ''
        ];

        return $purchaseUnits;
    }
}
