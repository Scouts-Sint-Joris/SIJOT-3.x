<?php

namespace Sijot\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $role
     * @param  null|string              $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (Auth::guest()) {
            return redirect('/');
        }

        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        if (! is_null($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
