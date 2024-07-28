<?php

namespace App\Http\View\Composers;

use App\Http\Services\CartService;
use Illuminate\View\View;

class CartCurrentContentComposer
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function compose(View $view)
    {
        $view->with('cartItems', $this->cartService->getCart());
    }
}
