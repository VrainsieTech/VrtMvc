# Error Handling in VrtMVC

## Overview
VrtMVC provides a robust error-handling mechanism to catch and log errors effectively. It ensures that errors are reported clearly in development and logged silently in production.

## Default Error Handling
By default, VrtMVC captures exceptions and displays a friendly error page in development mode. In production, it logs errors instead of exposing sensitive details.

## Exception Handling
All unhandled exceptions are caught by VrtMVC's exception handler. Custom exceptions can be created and managed efficiently.

### Creating a Custom Exception
```php
namespace App\Exceptions;

use Exception;

class CustomException extends Exception {
    public function errorMessage() {
        return "A custom error occurred: " . $this->getMessage();
    }
}
```

### Throwing an Exception
```php
throw new CustomException("Something went wrong!");
```

## Logging Errors
Errors and exceptions are logged into `storage/logs/error.log`.

```php
use VrtMVC\Core\Logger;

Logger::error("Database connection failed");
```

## Custom Error Pages
You can define custom error pages for different HTTP status codes in `src/Views/errors/`.

For a 404 error page, create `src/Views/errors/404.php`:
```php
<h1>Page Not Found</h1>
<p>Sorry, the page you are looking for does not exist.</p>
```

## Summary
- VrtMVC captures and logs errors efficiently.
- Custom exceptions allow fine-grained error control.
- Errors are logged in `storage/logs/error.log`.
- Custom error pages can be created for better UX.

