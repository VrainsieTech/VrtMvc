# Middleware in VrtMVC

## Overview
Middleware in VrtMVC provides a way to filter HTTP requests before they reach the controller. It is useful for tasks like authentication, logging, and request modification.

## Creating Middleware
You can create middleware manually or use the CLI:
```bash
./vrtcli make:middleware AuthMiddleware
```
This generates `src/Middleware/AuthMiddleware.php`.

## Basic Middleware Structure
Middleware classes implement the `handle` method to process requests:
```php
namespace App\Middleware;

use VrtMVC\Core\Middleware;
use VrtMVC\Core\Request;
use VrtMVC\Core\Response;

class AuthMiddleware extends Middleware {
    public function handle(Request $request, Response $response, callable $next) {
        if (!isset($_SESSION['user'])) {
            return redirect('/login');
        }
        return $next($request, $response);
    }
}
```

## Applying Middleware
Middleware can be applied globally or to specific routes.

### Global Middleware
Register middleware in `config/middleware.php`:
```php
return [
    'auth' => App\Middleware\AuthMiddleware::class,
];
```

### Route Middleware
Apply middleware in `routes/web.php`:
```php
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
```

## Summary
- Middleware processes requests before they reach controllers
- Can be created via CLI or manually
- Supports global and route-specific application

