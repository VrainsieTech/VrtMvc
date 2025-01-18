<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Closure;

class SanitizeInputMiddleware
{
    function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$item, $key) {
            if (is_string($item)) {
                $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); // Basic XSS protection
                //Add more sanitization if needed
            }
        });
        $request->replace($input);

        return $next($request);
    }
}