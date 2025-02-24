# Error Handling in VrtMVC

## Overview
VrtMVC provides a robust error handling system that ensures smooth debugging and logging of errors. The framework captures PHP errors, exceptions, and fatal shutdown events, logging them for later review.

## Features
- Handles PHP errors and uncaught exceptions
- Logs errors to a specified file
- Displays errors if debug mode is enabled
- Handles fatal errors on script shutdown

## Initialization
To enable error handling in VrtMVC, initialize the error handler in your application:
```php
use Vrainsietech\Vrtmvc\Core\ErrorHandler;

ErrorHandler::initialize(true, __DIR__ . '/../storage/logs');
```
- The first argument (`true`) enables debug mode (errors will be displayed on the screen).
- The second argument specifies the directory where error logs should be stored.

## Handling Errors
### PHP Errors
All PHP warnings, notices, and other errors are automatically captured:
```php
trigger_error("This is a test error", E_USER_WARNING);
```

### Exceptions
Uncaught exceptions are automatically handled:
```php
throw new Exception("Something went wrong!");
```

### Fatal Errors
Fatal errors, such as syntax errors or out-of-memory issues, are logged and handled gracefully by the shutdown function.

## Logging
Errors and exceptions are logged to the specified log file (`logs/error.log` by default). The log format includes timestamps for better tracking.

## Customizing Error Handling
You can modify how errors are handled by updating the `ErrorHandler` class, such as customizing log locations or modifying the display output.

## Summary
- **Enable error handling** by initializing `ErrorHandler::initialize()`
- **Capture errors and exceptions** automatically
- **Log errors** for debugging purposes
- **Customize error handling** as needed

This system ensures that VrtMVC applications remain stable and maintainable, even in the presence of unexpected issues.

