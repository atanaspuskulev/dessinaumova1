<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Helpers\Cart;
use Illuminate\View\View;

class CartItemsComposer
{
    public function compose(View $view)
    {
        $view->with('cart_items', Cart::getCartFromSession());
    }
}
