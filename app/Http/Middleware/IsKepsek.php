<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsKepsek
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isKepsek()) {
            abort(403, 'Unauthorized - Kepala Sekolah Only');
        }

        return $next($request);
    }
}