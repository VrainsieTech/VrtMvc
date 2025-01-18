<?php

namespace Vrainsietech\Vrtmvc\Middleware;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\RedirectResponse;
use Closure;

require_once('../../config/config.php');

class MaintenanceModeMiddleware
{
    function handle(Request $request, Closure $next)
    {
        if (MAINTENANCE_MODE === 'true') { // Check Constant from config
            return new RedirectResponse('/maintenance');
        }

        return $next($request);
    }
}