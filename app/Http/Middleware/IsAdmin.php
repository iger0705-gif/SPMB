<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isVerifikator())) {
            abort(403, 'Unauthorized - Admin Only');
        }

        return $next($request);
    }
}
