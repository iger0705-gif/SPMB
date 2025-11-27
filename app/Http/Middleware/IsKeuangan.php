<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsKeuangan
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isKeuangan()) {
            abort(403, 'Unauthorized - Keuangan Only');
        }

        return $next($request);
    }
}