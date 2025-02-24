# VrtMVC Architecture

## Overview
VrtMVC is built on the **Model-View-Controller (MVC)** architecture, ensuring separation of concerns and an organized code structure. This guide explains the core components of the framework.

## MVC Structure
### 1. Model
The **Model** handles data management and database interactions. It extends the base model, providing built-in database transactions.
- Located in `src/Models/`
- Example:
```php
class User extends Model {
    protected $table = 'users';
}
```

### 2. View
The **View** is responsible for rendering the UI using VrtMVC’s templating engine.
- Located in `src/Views/`
- Example:
```php
<h1>Hello, {{name}}!</h1>
```
Easily pass data to the view from controller and the templating engine will pass in the variables. No more php opening and closing tags. You can only use the tags where you can't avoid.


### 3. Controller
The **Controller** acts as an intermediary between Models and Views.
- Located in `src/Controllers/`
- Example:
```php
class HomeController extends Controller {
    public function index() {
        return (new Response->view('home', ['name' => 'VrtMVC']));
    }
}
```

## Routing System
VrtMVC includes a built-in router that directs HTTP requests.
- Routes are defined in `routes/web.php`
- Example:
```php
$router->get('/home', [HomeController::class, 'index']);
```

## HTTP Layer
- Handles requests and responses
- Provides middleware support

## Configuration
- `.env` file stores environment settings
- `config/` directory contains configurable parameters

## Summary
The VrtMVC architecture ensures clean, maintainable, and scalable code. By leveraging the MVC pattern, developers can efficiently structure their applications.

