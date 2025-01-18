<?php

// Check if run from CLI
if (php_sapi_name() !== 'cli') {
    die('This script must be run from the command line.');
}

echo "Starting installation...\n";

// 1. Create .env file (if it doesn't exist)
if (!file_exists('.env')) {
    echo "Creating .env file...\n";
    copy('.env.example', '.env'); // Copy from example file
} else {
    echo ".env file already exists.\n";
}

// 2. Set Application Key
$key = bin2hex(random_bytes(32));
$envFile = file_get_contents('.env');
$envFile = preg_replace('/APP_KEY=/', 'APP_KEY=' . $key, $envFile);
file_put_contents('.env', $envFile);
echo "Application key set.\n";


// 3. Database Configuration
$dbHost = readline("Database Host (default: localhost): ");
$dbName = readline("Database Name: ");
$dbUser = readline("Database User: ");
$dbPassword = readline("Database Password: ");

$envFile = file_get_contents('.env');
$envFile = preg_replace('/DB_HOST=/', 'DB_HOST=' . ($dbHost ?: 'localhost'), $envFile);
$envFile = preg_replace('/DB_DATABASE=/', 'DB_DATABASE=' . $dbName, $envFile);
$envFile = preg_replace('/DB_USERNAME=/', 'DB_USERNAME=' . $dbUser, $envFile);
$envFile = preg_replace('/DB_PASSWORD=/', 'DB_PASSWORD=' . $dbPassword, $envFile);
file_put_contents('.env', $envFile);

echo "Database configuration updated in .env.\n";

// 4. Run Migrations (if applicable)
if (file_exists('artisan')) { // Check if you have an artisan-like command
    echo "Running database migrations...\n";
    passthru('php artisan migrate'); // Or your framework's migration command
} else {
    echo "No migrations found.\n";
}

// 5. Set Storage Permissions
if (is_dir('storage')) {
    echo "Setting storage permissions...\n";
    chmod('storage', 0755); // Or a more restrictive permission if needed
    chmod('bootstrap/cache', 0755);
}

echo "Installation complete!\n";