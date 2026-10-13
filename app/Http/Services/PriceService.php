<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class PriceService
{
    public function calculatePrice(Collection $prices, bool $applyTaxRate = false, float|null $taxRate = 0.15): float
    {
        $amount = 0.00;

        foreach($prices as $price) {
            $amount += $price;
        }

        if($applyTaxRate && $taxRate) {
            $amount *= (1 + $taxRate);
        }

        return round($amount, 2);
    }

    public function calculateShippingPrice(Collection $prices): float
    {
        // Handle free delivery first. Immediately return if there's a 0.00 price
        // which indicates free delivery.
        if($prices->contains(0.00)) {
           return 0.00;
        }

        return (float) $prices->max();
    }

    public function formatPrice(float $price, ?string $currency = null)
    {
        $currency = 'EUR';

        $money = new Money(((int) round($price * 100)), new Currency($currency));
        $currencies = new ISOCurrencies();

        if (!$currencies->contains(new Currency($currency))) {
            throw new InvalidArgumentException("Currency not supported: $currency");
        }

        $nf = new NumberFormatter(config('locale-mapper')[App::getLocale()], NumberFormatter::CURRENCY);
        return (new IntlMoneyFormatter($nf, $currencies))->format($money);
    }
}
