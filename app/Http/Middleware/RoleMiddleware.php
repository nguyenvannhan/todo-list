<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = Auth::user()->role_id ? 'admin' : 'normal';

        if (! empty($roles) && ! \in_array($userRole, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
