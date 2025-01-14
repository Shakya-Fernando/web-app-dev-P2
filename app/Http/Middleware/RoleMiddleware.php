<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // Check if user is student or teacher
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role != $role) {
            abort(403, 'Unauthorized access.');
        }
    
        return $next($request);
    }
    
}

