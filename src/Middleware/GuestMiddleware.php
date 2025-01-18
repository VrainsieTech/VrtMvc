<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\RedirectResponse;
use Closure;
use Vrainsietech\Vrtmvc\Models\Auth;

class GuestMiddleware
{
    function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return new RedirectResponse('/home'); // Or wherever logged-in users go
        }

        return $next($request);
    }
}