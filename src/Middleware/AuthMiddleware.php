<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\RedirectResponse;
use Closure;
use Vrainsietech\Vrtmvc\Core\Auth; 

class AuthMiddleware
{
    function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Store intended URL to redirect back after login
            if ($request->getMethod() !== 'get') {
                $_SESSION['intended_url'] = $request->fullUrl();
            }
            return new RedirectResponse('/login');
        }

        return $next($request);
    }
}