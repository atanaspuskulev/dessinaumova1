<?php

declare(strict_types=1);

namespace App\Directives;

class ShippingCostDirective
{
    public static function shippingCostLabel(
        float|int $shippingCost,
        string $freeShippingCostLabel = 'free',
        string $currencySign = "&euro;"
    ): string
    {
        if ((int) $shippingCost === 0) {
            return '<span class="text-success1">' . trans('site.'.$freeShippingCostLabel) . '</span>';
        }

        return number_format($shippingCost, 2) . $currencySign;
    }
}
