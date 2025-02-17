<?php

declare(strict_types=1);

namespace App\Directives;

use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class DisplayPriceDirective
{
    public static function displayPrice($price, $currentCurrency = null): string
    {
        $currency = $currentCurrency ?? config('payment.currency');

        $money = new Money(((int) round($price * 100)), new Currency($currency));
        $currencies = new ISOCurrencies();

        if (!$currencies->contains(new Currency($currency))) {
            throw new InvalidArgumentException("Currency not supported: $currency");
        }

        $nf = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        return (new IntlMoneyFormatter($nf, $currencies))->format($money);
    }
}
