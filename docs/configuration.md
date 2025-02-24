# Configuration in VrtMVC

## Overview
VrtMVC provides a simple and efficient way to manage configuration settings through the `Config` class. This system allows developers to load, retrieve, and modify configuration values dynamically. Additionally, configurations can be cached for better performance.

## Loading Configuration
Configuration files are stored in PHP files inside a specified directory (e.g., `config/`). When the application initializes, it loads all configuration files into memory.

To load configurations:
```php
Config::load(__DIR__ . '/../config');
```
This will scan the directory and load all `.php` files into the configuration array.

## Retrieving Configuration Values
To retrieve configuration values, use the `get` method:
```php
$dbConnection = Config::get('database.default', 'mysql');
```
- The first argument is the key in dot notation (`database.default` refers to `config/database.php` file and its `default` key).
- The second argument is the default value returned if the key does not exist.

## Setting Configuration Values
You can dynamically change configuration settings at runtime using the `set` method:
```php
Config::set('app.debug', true);
```
This updates the configuration value while the application is running.

## Configuration Caching
For performance optimization, VrtMVC supports configuration caching. When caching is enabled, configurations are stored in a single file to speed up access.

### Enabling Configuration Caching
Set the environment variable `APP_CACHE_CONFIG=true` and call:
```php
Config::cache();
```
This generates a cached configuration file at `bootstrap/cache/config.php`, reducing file I/O operations.

### Clearing Cached Configuration
To clear the cached configuration and force a reload from config files:
```php
Config::clearCache();
```
This deletes the cached file and allows new changes to take effect.


## Configuration Files
Additional settings can be found in the `config/` directory. These files control various aspects of the framework.

### 1. `config/app.php`
- Defines application-wide settings, such as timezone and debug mode.
- Example:
```php
return [
    'name' => getenv('APP_NAME', 'VrtMVC'),
    'env' => getenv('APP_ENV', 'production'),
    'debug' => getenv('APP_DEBUG', false),
];
```

### 2. `config/database.php`
- Configures database connections.
- Example:
```php
return [
    'default' => getenv('DB_CONNECTION', 'mysql'),
        'connections' => [
            'mysql' => [
                'host' => getenv('DB_HOST', 'localhost'),
                'port' => getenv('DB_PORT', 3306),
                'database' => getenv('DB_NAME'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASS')
        ],
    ],
];
```

### 3. `config/session.php`
- Manages session storage and settings.
- Example:
```php
return [
    'driver' => getenv('SESSION_DRIVER', 'file'),
    'lifetime' => 120,
];
```


## Summary
- Configurations are loaded from PHP files inside the `config/` directory.
- The `Config::get()` method retrieves values using dot notation.
- The `Config::set()` method modifies values dynamically.
- Configuration caching improves performance and can be cleared when needed.

VrtMVC allows flexible configuration through `.env` files and dedicated `config/` files. Modify these settings to tailor the framework to your application's needs. You can add as many config files to the `config/` directory if you ever feel you are not having enough though the defaults provided are the many you will ever need.

