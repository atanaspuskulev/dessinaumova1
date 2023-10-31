<?php

declare(strict_types=1);

namespace App\Http\Middleware;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
class GlobalData
{
    public function handle(Request $request, \Closure $next): Response|RedirectResponse
    {
        View::share([
            'current_path' => request()->path()
        ]);

        return $next($request);
    }
}
