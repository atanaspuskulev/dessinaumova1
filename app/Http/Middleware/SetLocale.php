<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);
        if (in_array($locale, ['bg', 'en'])) {
            app()->setLocale($locale);
        } else {
            // fallback locale if no valid prefix
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
