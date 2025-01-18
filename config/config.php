<?php

// Database configuration
define('DB_HOST', 'localhost'); // Or your database server address
define('DB_USER', 'vrainsie');
define('DB_PASS', 'Gg880#$(5dn(%)s');
define('DB_NAME', 'vrtmvc');

// Application settings
define('APP_NAME', 'VrtMvc');
define('APP_URL', 'http://localhost/vrtmvc'); // Your application URL
define('BASE_PATH', __DIR__ . '/..'); // Root directory of your application
define('DEBUG_MODE', true); // Set to false in production

// Error reporting (recommended settings)
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', BASE_PATH . '/logs/error.log'); // Path to your error log file
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); // Log everything except notices, strict standards, and deprecated warnings
}

// Default controller and action (for routing)
define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_ACTION', 'index');

// Templating settings (if needed)
define('VIEW_PATH', BASE_PATH . '/src/views/');
define('CACHE_PATH', BASE_PATH . '/cache/'); // For template caching if implemented

// Other settings
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');

// Optional - Timezone
date_default_timezone_set('Africa/Nairobi'); // Example Timezone

// Optional - Salt for password hashing (important for security)
define('PASSWORD_SALT', 'a_very_long_and_random_string_for_salting');

// Optional - CSRF token name
define('CSRF_TOKEN_NAME', 'csrf_token');


//You can also store configurations as an array

$config = [
    'database' => [
        'host' => 'localhost',
        'user' => 'your_db_user',
        'password' => 'your_db_password',
        'name' => 'your_db_name',
    ],
    'app' => [
        'name' => 'My MVC Framework',
        'url' => 'http://localhost/my-mvc-app',
    ],
    // ... other configurations
];

//Example how to access the array config
//echo $config['database']['host'];


return $config; // If you want to use the array configuration