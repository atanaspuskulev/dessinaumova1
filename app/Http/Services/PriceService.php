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
}
