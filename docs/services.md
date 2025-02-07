# Services in VrtMVC

## Overview
Services in VrtMVC provide a way to manage reusable logic and dependencies across the application. The framework includes a **service container** for dependency injection, allowing for loosely coupled components.

## Creating a Service
You can create a service manually or use the CLI:
```bash
./vrtcli make:service PaymentService
```
This generates `src/Services/PaymentService.php`.

## Basic Service Structure
A service class contains logic that can be injected into controllers or other parts of the application:
```php
namespace App\Services;

class PaymentService {
    public function processPayment($amount) {
        return "Processing payment of ".$amount;
    }
}
```

## Using Services in Controllers
Inject a service into a controller:
```php
namespace App\Controllers;

use App\Services\PaymentService;

class OrderController extends Controller {
    protected $paymentService;

    public function __construct(PaymentService $paymentService) {
        $this->paymentService = $paymentService;
    }

    public function checkout() {
        return $this->paymentService->processPayment(100);
    }
}
```

## Registering Services
Services are registered in `config/services.php`:
```php
return [
    'payment' => App\Services\PaymentService::class,
];
```

## Accessing Services
Retrieve a service instance using the service container:
```php
$paymentService = app('payment');
$result = $paymentService->processPayment(100);
echo $result;
```

## Summary
- Services allow modular and reusable logic
- Dependency injection ensures flexibility
- Registered in `config/services.php` and accessible via `app('service_name')`

