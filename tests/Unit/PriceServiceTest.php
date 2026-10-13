<?php

namespace Tests\Unit;

use App\Http\Services\PriceService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class PriceServiceTest extends TestCase
{
    public function test_prices_include_optional_tax_and_shipping_respects_free_delivery(): void
    {
        $service = new PriceService;
        $prices = new Collection([19.99, 5.50]);

        $this->assertSame(25.49, $service->calculatePrice($prices));
        $this->assertSame(30.59, $service->calculatePrice($prices, true, 0.20));
        $this->assertSame(0.0, $service->calculatePrice(new Collection));

        $this->assertSame(7.50, $service->calculateShippingPrice(new Collection([4.00, 7.50, 5.00])));
        $this->assertSame(0.0, $service->calculateShippingPrice(new Collection([4.00, 0.00, 7.50])));
        $this->assertSame(0.0, $service->calculateShippingPrice(new Collection));
    }
}
