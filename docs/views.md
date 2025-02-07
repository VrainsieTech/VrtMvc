# Views in VrtMVC

## Overview
Views in VrtMVC are responsible for rendering the user interface. They are stored in the `src/Views/` directory and use the framework’s templating engine.

## Creating a View
You can create a view manually or use the CLI:
```bash
./vrtcli make:view home
```
This generates `src/Views/home.php`.

## Basic View Structure
A typical view file contains HTML with embedded PHP for dynamic content:
```php
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?= $name; ?>!</h1>
</body>
</html>
```

## Rendering a View
Views are returned from a controller using the `view()` helper:
```php
class HomeController extends Controller {
    public function index() {
        return view('home', ['name' => 'VrtMVC']);
    }
}
```

## Template Inheritance
VrtMVC supports template inheritance using layouts. Example layout file `layout.php`:
```php
<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
</head>
<body>
    <?= $content; ?>
</body>
</html>
```

To extend the layout in a view:
```php
<?php $title = 'Dashboard'; ?>
<?php $content = '<h1>Welcome to the dashboard</h1>'; ?>
```

## Including Partial Views
You can include partials using:
```php
<?php include 'partials/navbar.php'; ?>
```

## Summary
- Views define the UI and use the templating engine
- Use the `view()` helper to render views from controllers
- Supports template inheritance and partials for modular design

