<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use App\Http\Services\CartService;
use Illuminate\View\View;

readonly class CartCurrentContentComposer
{

    public function compose(View $view)
    {
        $view->with('cartItems', []);
    }
}
