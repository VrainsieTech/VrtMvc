# AJAX Handling in VrtMVC

## Overview
VrtMVC comes with built-in AJAX support, allowing dynamic and asynchronous data handling without requiring developers to write additional JavaScript functions or files.

## Built-in JavaScript Helper
A global JavaScript helper (`vrtjs.js`) is included in the `public/assets/vrtjs` directory. It provides two key functions:

### 1. `vrtmvc.ajax(url, data, method, callback)`
This function performs an AJAX request and processes the response.
```js
vrtmvc.ajax('/users', {}, 'GET', function(response) {
    console.log(response);
});
```

### 2. `vrtmvc.submitForm(formId, callback)`
Automatically converts a form submission into an AJAX request.
```html
<form id="loginForm" action="/login" method="POST">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>

<script>
vrtmvc.submitForm("loginForm", function(response) {
    alert(response.message);
});
</script>
```

## Controller Support for AJAX
Extend controllers from base `Controller` to return JSON responses.
```php
namespace Vrainsietech\Vrtmvc\Controllers;

use Vrainsietech\Vrtmvc\Core\Request;
use Vrainsietech\Vrtmvc\Core\Response;
use Vrainsietech\Vrtmvc\Core\Controller;

class UserController extends Controller {
    public function getUsers(Request $request, Response $response) {
        $users = User::all();
        return $this->jsonResponse($response, $users);
    }
}
```

## Example: Fetching Data via AJAX
```html
<button onclick="fetchUsers()">Load Users</button>
<div id="userList"></div>

<script>
function fetchUsers() {
    vrtmvc.ajax("/users", {}, "GET", function(data) {
        document.getElementById("userList").innerHTML = data.map(user => `<p>${user.name}</p>`).join("");
    });
}
</script>
```

## Summary
- VrtMVC includes built-in AJAX utilities for easy asynchronous requests.
- Forms can be submitted via AJAX without extra JavaScript.
- Controllers can return JSON responses easily.
- The framework provides a simple way to update UI dynamically without reloading the page.

