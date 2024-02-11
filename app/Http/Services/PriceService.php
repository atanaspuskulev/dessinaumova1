<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;

class PriceService
{
    public function calculatePrice(Collection $prices, bool $applyTaxRate = false, float|null $taxRate = null): float
    {
        $amount = 0.00;

        foreach($prices as $price) {
            $amount += $price;
        }

        if($applyTaxRate && $taxRate) {
            $amount += $amount * $taxRate;
        }

        return $amount;
    }
}
