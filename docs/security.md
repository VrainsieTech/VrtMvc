# Security in VrtMVC

## Overview
VrtMVC prioritizes security by implementing measures against common web vulnerabilities such as CSRF, XSS, SQL injection, and unauthorized access.

## CSRF Protection
VrtMVC includes built-in CSRF protection to prevent cross-site request forgery attacks.

### Enabling CSRF Protection
CSRF tokens are automatically generated and validated for forms.
```php
<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
```
To verify CSRF tokens in controllers:
```php
if (!verify_csrf(request('_token'))) {
    throw new Exception("Invalid CSRF token");
}
```

## XSS Protection
All input is automatically escaped to prevent cross-site scripting attacks.
```php
<?= e($user_input); ?>
```

## SQL Injection Prevention
VrtMVC uses prepared statements and parameterized queries to prevent SQL injection.
```php
$query = "SELECT * FROM users WHERE email = ?";
$results = DB::query($query, [$email]);
```

## Authentication and Authorization
VrtMVC has a built-in authentication system with session-based user management.
```php
if (!auth()->check()) {
    redirect('/login');
}
```
Roles and permissions can be defined in middleware:
```php
if (!auth()->user()->hasRole('admin')) {
    abort(403, "Unauthorized access");
}
```

## Encryption
VrtMVC supports encryption and hashing for secure data storage.
```php
$hashedPassword = hash_password("secret");
if (verify_password("secret", $hashedPassword)) {
    echo "Password is valid";
}
```

## Summary
- CSRF protection is enabled by default.
- XSS is prevented through automatic escaping.
- SQL injection is mitigated with prepared statements.
- Authentication and authorization are built-in.
- Secure hashing and encryption are available for sensitive data.

