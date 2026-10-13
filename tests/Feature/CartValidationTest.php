<?php

namespace Tests\Feature;

use Tests\TestCase;

class CartValidationTest extends TestCase
{
    public function test_invalid_cart_input_is_rejected_without_changing_the_cart(): void
    {
        $cart = [['product_id' => 42, 'quantity' => 2, 'price' => '20.00', 'real_price' => 10.00]];

        foreach ([[], ['product_id' => 'invalid', 'quantity' => 'invalid'], ['product_id' => 0, 'quantity' => -1]] as $input) {
            $this->withSession(['cart' => $cart])
                ->postJson(route('front.cart.add'), $input)
                ->assertUnprocessable()
                ->assertJsonValidationErrors(['product_id', 'quantity'])
                ->assertSessionHas('cart', $cart);
        }
    }
}
