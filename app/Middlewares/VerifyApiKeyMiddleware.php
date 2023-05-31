<?php

namespace App\Middlewares;

use Bow\Http\Exception\ForbiddenException;
use Bow\Http\Request;
use Bow\Middleware\BaseMiddleware;

class VerifyApiKeyMiddleware implements BaseMiddleware
{
    /**
     * Launch function of the middleware.
     *
     * @param  Request $request
     * @param  callable $next
     * @param  array $args
     * @return mixed
     */
    public function process(Request $request, callable $next, array $args = []): mixed
    {
        $api_key = $request->getHeader("X-Api-Key");

        if (app_env("API_KEY") == $api_key) {
            return $next($request);
        }

        throw new ForbiddenException(
            "Access denied"
        );
    }

    /**
     * Get redirect url
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return '/';
    }
}
