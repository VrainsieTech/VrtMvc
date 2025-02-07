# Testing in VrtMVC

## Overview
VrtMVC includes built-in support for testing applications, ensuring stability and reliability. It supports unit tests, feature tests, and HTTP request testing.

## Setting Up Tests
Tests are stored in the `tests/` directory. To set up PHPUnit, ensure you have the dependencies installed:
```bash
composer require --dev phpunit/phpunit
```
Run tests using:
```bash
./vendor/bin/phpunit
```

## Writing Unit Tests
Unit tests ensure that individual components work as expected. Example:
```php
use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase {
    public function testUserCanBeCreated() {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);
        $this->assertEquals('John Doe', $user->name);
    }
}
```

## Feature Testing
Feature tests verify that multiple components work together.
```php
use Tests\TestCase;

class AuthTest extends TestCase {
    public function testLoginPageLoads() {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
}
```

## HTTP Request Testing
VrtMVC provides utilities to test HTTP requests and responses.
```php
use Tests\TestCase;

class ApiTest extends TestCase {
    public function testApiReturnsJson() {
        $response = $this->getJson('/api/data');
        $response->assertJson(['success' => true]);
    }
}
```

## Running Tests
Execute all tests with:
```bash
./vendor/bin/phpunit tests
```
Run a specific test:
```bash
./vendor/bin/phpunit --filter UserTest
```

## Summary
- Use PHPUnit for unit and feature tests.
- Store tests in the `tests/` directory.
- Run tests using `phpunit`.
- Test HTTP responses using built-in utilities.

