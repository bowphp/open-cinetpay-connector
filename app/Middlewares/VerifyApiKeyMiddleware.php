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
        $api_key = (string) $request->getHeader("X-Api-Key");
        $expected = (string) app_env("API_KEY");

        // Fail closed when no key is configured, and compare in constant time:
        // a loose == let an absent header match an unset/empty key (null == null)
        // and leaked the key byte-by-byte through timing.
        if ($expected !== '' && hash_equals($expected, $api_key)) {
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
