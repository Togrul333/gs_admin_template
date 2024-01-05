<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        if (admin() &&  admin()->role_id !== 2) {
            return abort(403);
        }

        return $next($request);
    }
}
