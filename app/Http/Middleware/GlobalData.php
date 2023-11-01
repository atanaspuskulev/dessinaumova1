<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GlobalData
{
    public function handle(Request $request, \Closure $next)
    {
        View::share([
            'current_path' => request()->path()
        ]);

        return $next($request);
    }
}
