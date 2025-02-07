# Configuration Guide

## Overview
VrtMVC provides a flexible configuration system that allows developers to customize their applications easily. Configuration is handled through environment files and the `config/` directory.

## Environment Configuration
VrtMVC uses an `.env` file for managing environment-specific settings.

### Creating the `.env` File
After installation, an `.env` file is automatically generated. If not, create it manually by copying `.env.example`:
```bash
cp .env.example .env
```
Though in most cases, the `.env` is always created during installation. If you have not followed the installation guide, be sure to do so to have a smooth usage of the framework. Unless otherwise you trust your guts, use command above to manually copy and then edit as per your need.

### Editing Environment Variables
Modify the `.env` file to configure your application settings. Example:
```
APP_NAME=VrtMVC
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=vrtmvc
DB_USER=root
DB_PASSWORD=
```

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
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => env('DB_NAME', 'vrtmvc'),
            'username' => env('DB_USER', 'root'),
            'password' => env('DB_PASS', ''),
        ],
    ],
];
```

### 3. `config/session.php`
- Manages session storage and settings.
- Example:
```php
return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => 120,
];
```

## Dynamic Configuration
You can modify configurations dynamically in your code using:
```php
config::set('app.debug', true);
```

## Summary
VrtMVC allows flexible configuration through `.env` files and dedicated `config/` files. Modify these settings to tailor the framework to your application's needs. You can add as many config files to the config directory if you ever feel you are not having enough though the defaults provided are the many you will ever need.

