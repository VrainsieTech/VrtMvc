<?php

use Vrainsietech\Vrtmvc\Core\Router;
use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response;
use Vrainsietech\Vrtmvc\Http\RedirectResponse;
use Vrainsietech\Vrtmvc\Controllers\AuthController;
use Vrainsietech\Vrtmvc\Middleware\AuthMiddleware;
use Vrainsietech\Vrtmvc\Middleware\GuestMiddleware;

/** @var Router $router */

// Home Route (Example)
$router->get('/', function (Request $request) {
    return new Response('Welcome to VrtMVC!');
})->name('home');

// Authentication Routes
$router->group(['middleware' => [GuestMiddleware::class]], function (Router $router) {
    $router->get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    $router->post('/register', [AuthController::class, 'register']);

    $router->get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    $router->post('/login', [AuthController::class, 'login']);
});

$router->group(['middleware' => [AuthMiddleware::class]], function (Router $router) {
    $router->post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Password Reset Routes
$router->group(['middleware' => [GuestMiddleware::class]], function (Router $router) {
    $router->get('/auth/reset/{form}', [AuthController::class, 'showRequestForm'])->name('auth.reset');
    $router->post('/auth/email', [AuthController::class, 'sendLink'])->name('auth.email');
    $router->get('/auth/reset/{token}', [AuthController::class, 'showResetForm'])->name('auth.reset');
    $router->post('/auth/reset', [AuthController::class, 'reset'])->name('auth.update');
});

// Example protected route
$router->get('/dashboard', function () {
    return new Response('Dashboard (Protected)');
}, [AuthMiddleware::class])->name('dashboard');

//Example route with parameters
$router->get('/users/{id}', function (Request $request){
    $id = $request->getAttribute('routeParams')['id'];
    return new Response("User ID: ".$id);
})->name('user.show');

$router->get('/users', function (){
    return new Response("All users");
})->name('users.index');

$router->get('/redirect-test', function (){
    return RedirectResponse::namedRoute('user.show', ['id' => 123]);
});