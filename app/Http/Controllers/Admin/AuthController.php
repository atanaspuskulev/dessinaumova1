<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('admin.auth.login');
    }

    public function authUser(Request $request): RedirectResponse
    {
        if(Auth::attempt($request->only(['email', 'password']), (bool) $request->only(['rememberme']))) {
            return redirect()->route('admin.home');
        }

        return redirect()->back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
