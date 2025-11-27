<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVerifikator
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isVerifikator()) {
            abort(403, 'Unauthorized - Verifikator Only');
        }

        return $next($request);
    }
}