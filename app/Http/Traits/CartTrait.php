<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Http\RedirectResponse;

trait CartTrait
{
    public function checkValidCart(): RedirectResponse|null
    {
        if (session()->get('cart') === null) {
            return redirect()->to(route('front.index'));
        }
        return null;
    }

    public function checkCartRefererSource(): RedirectResponse|bool
    {
        $cref = session()->get('cref');
        $configCref = config('app.cart_referer');
        $returnTo = route('front.cart.index');

        if(!request()->has('cref')) {
            if ($cref && $cref === $configCref) {
                return true;
            }

            if($cref && $cref !== $configCref) {
                session()->forget('cref');
                return redirect()->to($returnTo);
            }
        } elseif(request()->get('cref') === $configCref) {
            return true;
        } elseif(request()->get('cref') !== $configCref) {
            session()->forget('cref');
            return redirect()->to($returnTo);
        }
    }

}
