<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response; // Or throw an exception
use Closure;
use Vrainsietech\Vrtmvc\Models\Auth;

class AuthorizeMiddleware
{
    private $permission;

    function __construct($permission)
    {
        $this->permission = $permission;
    }

    function handle(Request $request, Closure $next)
    {
        if (!Auth::hasPermission($this->permission)) {
            return new Response('Unauthorized', 403); // Or redirect or throw exception
        }

        return $next($request);
    }
}