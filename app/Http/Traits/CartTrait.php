<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\Product;

trait CartTrait
{
    public function checkValidCart()
    {
        if (session()->get('cart') === null) {
            return redirect()->to(route('front.index'));
        }
        return null;
    }

    public function checkDeliveryAddress()
    {
        return session()->get('delivery-information') === null
            ? redirect()->to(route('front.index'))
            : null;
    }

    public function checkCartRefererSource()
    {
        $returnTo = route('front.cart.index');

        $cref = session()->has('cref')
            ? (int) session()->get('cref')
            : null;

        $requestCref = request()->has('cref')
            ? (int) request()->get('cref')
            : (session()->has('session_cref') ? (int) session()->get('session_cref') : null);

        if(($cref && $requestCref) && ($cref === $requestCref)) {
            return true;
        }

        session()->forget('cref');
        return redirect()->to($returnTo);
    }

    public function calculateCartAmount(array $productsIds): float
    {
        $amount = 0.00;

        Product::whereIn('id', $productsIds)
            ->get()
            ->map(static function($record) use (&$amount) {
                $amount += $record->price;
            });

        return $amount;
    }

    public function clearCrefKeys(): void
    {
        session()->forget(['cref', 'session_cref']);
    }
}
