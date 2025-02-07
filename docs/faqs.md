# Frequently Asked Questions (FAQ)

## 1. What is VrtMVC?
VrtMVC is a lightweight yet powerful PHP framework designed for developers who need a simple and efficient MVC structure without the overhead of larger frameworks.

## 2. What PHP version is required?
VrtMVC requires PHP 7.4 or higher to ensure compatibility and security.

## 3. How do I install VrtMVC?
You can install VrtMVC using Composer:
```bash
composer require vrainsietech/vrtmvc
```
Then, run the installation command:
```bash
./install
```

## 4. How do I configure the database?
Modify the `.env` file to set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

## 5. Can I use SQLite for development?
Yes, VrtMVC supports SQLite for development. Update the `.env` file with:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## 6. How do I create controllers, models, and views?
Use the built-in CLI tool:
```bash
./vrtcli make:controller MyController
./vrtcli make:model MyModel
./vrtcli make:view myview
```

## 7. How do I define routes?
Routes are defined in `routes/web.php`:
```php
Route::get('/home', [HomeController::class, 'index']);
```

## 8. How do I enable authentication?
VrtMVC includes built-in authentication. Run:
```bash
./vrtcli make:auth
```
This sets up login, registration, and password reset.

## 9. How do I handle middleware?
Middleware is defined in `src/Middleware/`. Register it in `config/middleware.php`:
```php
return [
    'auth' => App\Middleware\AuthMiddleware::class,
];
```
Apply it to routes as needed:
```php
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
```

## 10. How do I deploy my VrtMVC application?
Follow the [Deployment Guide](deployment.md) for steps on hosting your application on Apache, Nginx, or cloud services.

## 11. Where can I get support?
For support, contact vrainsietech@gmail.com or check the documentation and community forums.

## 12. How can I contribute to VrtMVC?
Contributions are welcome! See the [Contributing Guide](contributing.md) for details on how to submit bug reports, feature requests, and code contributions.

