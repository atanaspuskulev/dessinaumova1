<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;

class PriceService
{
    public function calculatePrice(Collection $prices, bool $applyTaxRate = false, float|null $taxRate = 0.15): float
    {
        $applyTaxRate ??= false;
        $amount = 0.00;

        foreach($prices as $price) {
            $amount += $price;
        }

        if($applyTaxRate && $taxRate) {
            $taxAmount = $amount * $taxRate;
            $amount += $taxAmount;
        }

        return round($amount);
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
}
