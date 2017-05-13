<?php

namespace Sijot\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class ForbidBannedUser.
 *
 * @package Cog\Ban\Http\Middleware
 */
class ForbidBannedUser
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->isBanned()) {
            abort(402);
        }

        return $next($request);
    }
}

