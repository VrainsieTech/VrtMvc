<?php

define('BASE_PATH', __DIR__ . '/../');

// Load Composer autoloader
require_once BASE_PATH . 'vendor/autoload.php';

// Load .env file (EARLY in the process)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../.env'); // Path to .env
$dotenv->load();

// Start session
session_start();

// Load configuration
use Vrainsietech\Vrtmvc\Config\Config;
Config::load(BASE_PATH . 'config');

// Instantiate core components (AFTER loading .env)
use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Core\Router;

$request = new Request();
$router = new Router($request);

// Define routes
require_once BASE_PATH . 'routes/web.php';

// Dispatch request
$response = $router->match();
$response->send();