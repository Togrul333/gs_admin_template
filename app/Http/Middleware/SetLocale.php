<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $segments = $request->segments();

        if (count($segments) > 0) {
            $availableLocales = ['en', 'ru'];
            if (in_array(locale(), $availableLocales)) {
                $newPath = '/' . implode('/', array_merge([locale()], $segments));
                $request->server->set('REQUEST_URI', $newPath);
            }
        }

        return $next($request);
    }
}
