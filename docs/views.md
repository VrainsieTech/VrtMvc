# VrtMVC View System

The VrtMVC framework provides a lightweight and flexible templating system for rendering views. It allows dynamic data injection, partial view inclusion, and error handling.

## 1. View Structure
By default, when a view is created using the CLI, it follows this structure:

```php
<?php include "header.php"; ?>
<section>
    I am in view {{ viewName }}. Add any HTML tags within this section
</section>
<?php include "footer.php"; ?>
```

- `header.php` contains all necessary HTML opening tags, metadata (from the `Seo` class), required assets, the navigation sidebar and topbar and the main layout opening.
- `footer.php` closes the main layout, body, and HTML tags.
- Users can manually add asset links if they create a view without the CLI.

## 2. Rendering Views
Views are PHP files that contain HTML and dynamic content. They are rendered using the `Response` class.

```php
return (new Response())->view('home', ['title' => 'Welcome', 'message' => 'Hello, VrtMVC!']);
```

This will load the `Views/home.php` file and pass the `title` and `message` variables to it.

## 3. Passing Data to Views
Data can be passed using the `with()` method:

```php
$view = new Views('Views/home.php');
$view->with('title', 'Welcome to VrtMVC')->with('message', 'Hello, World!');
$view->render();
```

Inside `home.php`, you can access these variables using the double curly braces syntax:

```html
<h1>{{ title }}</h1>
<p>{{ message }}</p>
```

## 4. Including Partial Views
Since `header.php` and `footer.php` are included by default, users only need to focus on content within the `<section>` tag.

Additional reusable components like sidebars or navigation are by default added. To change the feel to your need, edit the `Navigation` class in `src/Helpers/Navigation.php`

By default, the CLI generated View is responsive.


## 5. Error Handling in Views
If a view file does not exist, the framework will automatically render a 404 error view located at `Views/errors/404.php` (if available). Otherwise, a default error message will be shown.

```php
$view = new Views('Views/nonexistent.php', 'Views/errors/404.php');
$view->render();
```

## 6. Asset Management
CSS and JavaScript assets are automatically included in `header.php`. Users can:
- Define custom styles within `base`, `components`, `utilities`, and `layout`.
- Add additional asset links manually in `header.php` or within the specific view file if necessary.

Example manual inclusion:

```html
<link rel="stylesheet" href="/assets/css/custom-style.css">
<script src="/assets/js/custom-script.js"></script>
```

## 7. Summary
- Views follow a default structure with `header.php` and `footer.php`.
- Use `Response->view()` to render views.
- Pass data using `with()` or as an associative array.
- Include reusable components with `include`.
- Handle missing views with an error page.
- Assets are managed through `header.php`, with customization available in predefined CSS structures.

This system ensures a simple yet powerful way to manage views in VrtMVC.

