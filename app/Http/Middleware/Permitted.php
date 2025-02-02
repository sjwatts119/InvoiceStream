<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permitted
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->permitted) {
            abort(404);
        }

        return $next($request);
    }
}
