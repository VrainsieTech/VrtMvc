# Routing in VrtMVC

## Overview
VrtMVC includes a built-in routing system that maps HTTP requests to the appropriate controllers and methods. Routes are defined in the `routes/web.php` file.

## Defining Routes
Routes in VrtMVC follow a simple syntax:
```php
Route::get('/home', [HomeController::class, 'index']);
```
This maps the `/home` URL to the `index` method of `HomeController`.

### Supported HTTP Methods
VrtMVC supports various HTTP methods:
- `Route::get()` – Handles GET requests
- `Route::post()` – Handles POST requests
- `Route::put()` – Handles PUT requests
- `Route::delete()` – Handles DELETE requests

Example:
```php
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
```

## Route Parameters
VrtMVC allows passing dynamic parameters in routes:
```php
Route::get('/user/{id}', [UserController::class, 'show']);
```
Access the parameter in the controller:
```php
public function show($id) {
    return "User ID: " . $id;
}
```

## Named Routes
You can assign names to routes for easier reference:
```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```
Usage:
```php
$url = route('dashboard');
```

Though you can use routes without names, it is more recomended that you also add the name of the route.
This facilitates easier url/uri creation on the router. It increases speed and efficiency.

## Middleware
Apply middleware to routes for additional processing:
```php
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
```

## Grouping Routes
Routes can be grouped to share attributes:
```php
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/users', [UserController::class, 'index']);
});
```

## Summary
- Define routes in `routes/web.php`
- Use various HTTP methods
- Utilize route parameters and named routes
- Apply middleware for security and access control
- Group related routes for better organization

