<?php

namespace Sijot\Http\Middleware;

use Carbon\Carbon;
use Chrisbjr\ApiGuard\Events\ApiKeyAuthenticated;
use Chrisbjr\ApiGuard\Models\Device;
use Closure;

/**
 * Class AuthenticateApiKey
 *
 * @package Sijot\Http\Middleware
 */
class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $apiKeyValue = $request->header(config('apiguard.header_key', 'X-Authorization'));

        $apiKey = app(config('apiguard.models.api_key', 'Chrisbjr\ApiGuard\Models\ApiKey'))
            ->where('key', $apiKeyValue)
            ->first();

        if (empty($apiKey)) {
            return $this->unauthorizedResponse();
        }

        // Update this api key's last_used_at and last_ip_address
        $apiKey->update(['last_used_at' => Carbon::now(), 'last_ip_address' => $request->ip()]);

        $apikeyable = $apiKey->apikeyable;

        // Bind the user or object to the request
        // By doing this, we can now get the specified user through the request object in the controller using:
        //
        // $request->user();
        $request->setUserResolver(function () use ($apikeyable) {
            return $apikeyable;
        });

        // Attach the apikey object to the request
        $request->apiKey = $apiKey;

        event(new ApiKeyAuthenticated($request, $apiKey));

        return $next($request);
    }

    /**
     * Return a json response when the user is not authencated.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthorizedResponse()
    {
        return response([
            'error' => [
                'code' => '401', 'http_code' => 'GEN-UNAUTHORIZED', 'message' => 'Unauthorized.']
        ], 401);
    }
}
