# Controllers in VrtMVC

## Overview
Controllers in VrtMVC handle business logic and act as intermediaries between models and views. They are stored in the `src/Controllers/` directory.

## Creating a Controller
You can manually create a controller or use the CLI:
```bash
./vrtcli make:controller UserController
```
This generates `src/Controllers/UserController.php`.

## Basic Controller Structure
A typical controller extends the base `Controller` class:
```php
namespace Vrainsietech\Vrtmvc\Controllers;

use Vrainsietech\Vrtmvc\Core\Controller;

class UserController extends Controller {
    public function index() {
        $greeting = "Hello, I am from UserController"
        return (new Response())->view('user.show', ['greeting' => $greeting]);
    }
}
```

## Handling Requests
Controllers process requests and return responses:
```php
public function show($id) {
    $user = User::find($id);
    return (new Response())->view('users.show', ['user' => $user]);
}
```

## Using Middleware in Controllers
Apply middleware to controllers:
```php
class AdminController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
}
```

## Dependency Injection
VrtMVC supports dependency injection in controllers:
```php
public function __construct(UserService $userService) {
    $this->userService = $userService;
}
```

## Summary
- Controllers manage business logic
- Use the CLI to generate controllers
- Extend the base `Controller` class
- Handle requests and apply middleware
- Support dependency injection for cleaner code

