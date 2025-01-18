<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response;
use Closure;

class CsrfMiddleware
{
    function handle(Request $request, Closure $next)
    {
        if (in_array($request->getMethod(), ['post', 'put', 'patch', 'delete'])) {
            if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['csrf_token']) {
                return new Response('Invalid CSRF token.', 419); // Or throw an exception
            }
        }
        // Regenerate token for every request
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $next($request);
    }
}