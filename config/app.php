<?php

return [
    'name' => getenv('APP_NAME', 'My Application'),
    'debug' => getenv('APP_DEBUG', false),
    'timezone' => 'UTC',
];

// Error reporting (recommended settings)
if (getenv('APP_DEBUG')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', BASE_PATH . '/logs/error.log'); // Path to error log file
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); // Log everything except notices, strict standards, and deprecated warnings
}