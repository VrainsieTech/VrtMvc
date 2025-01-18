<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Closure;

class TrimStringsMiddleware
{
    function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$item, $key) {
           if (is_string($item)) {
               $item = trim($item);
           }
        });
        $request->replace($input);

        return $next($request);
    }
}