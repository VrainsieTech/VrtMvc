# Helpers in VrtMVC

## Overview
VrtMVC provides a set of built-in helper functions to simplify common tasks such as routing, rendering views, handling requests, and more.

## Available Helpers

### 1. `view($name, $data = [])`
Renders a view file with optional data.
```php
return view('home', ['title' => 'Welcome']);
```

### 2. `redirect($url)`
Redirects the user to a specified URL.
```php
return redirect('/dashboard');
```

### 3. `route($name, $params = [])`
Generates a URL for a named route.
```php
$url = route('profile', ['id' => 1]);
```

### 4. `request($key = null)`
Retrieves input from the request.
```php
$name = request('name');
```

### 5. `session($key, $default = null)`
Gets or sets session values.
```php
session('user', 'John Doe');
$user = session('user');
```

### 6. `config($key, $default = null)`
Retrieves configuration values.
```php
$dbHost = config('database.host');
```

### 7. `env($key, $default = null)`
Fetches environment variables from the `.env` file.
```php
$appEnv = env('APP_ENV', 'production');
```

### 8. `app($service)`
Resolves a service from the service container.
```php
$logger = app('logger');
```

## Summary
- VrtMVC offers various helper functions to streamline development.
- They cover views, routing, sessions, configuration, and service resolution.
- Helpers improve code readability and efficiency.

