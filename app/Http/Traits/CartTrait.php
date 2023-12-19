<?php

declare(strict_types=1);

namespace App\Http\Traits;

trait CartTrait
{
    public function checkValidCart()
    {
        if (session()->get('cart') === null) {
            return redirect()->to(route('front.index'));
        }
        return null;
    }

    public function checkCartRefererSource()
    {
        $returnTo = route('front.cart.index');

        $cref = session()->has('cref')
            ? (int) session()->get('cref')
            : null;

        $requestCref = request()->has('cref')
            ? (int) request()->get('cref')
            : null;

        if(($cref && $requestCref) && ($cref === $requestCref)) {
            return true;
        }

        session()->forget('cref');
        return redirect()->to($returnTo);
    }

}
