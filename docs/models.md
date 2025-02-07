# Models in VrtMVC

## Overview
Models in VrtMVC handle data interactions and communicate with the database. They are stored in the `src/Models/` directory and extend the base `Model` class.

## Creating a Model
You can create a model manually or use the CLI:
```bash
./vrtcli make:model User
```
This generates `src/Models/User.php`.

## Basic Model Structure
A typical model extends the base `Model` class and defines the table name:
```php
namespace App\Models;

use VrtMVC\Core\Model;

class User extends Model {
    protected $table = 'users';
}
```

## Retrieving Data
Use built-in methods to fetch data:
```php
$users = User::all(); // Get all users
$user = User::find(1); // Find a user by ID
```

## Inserting Data
To create a new record:
```php
$user = new User();
$user->name = 'John Doe';
$user->email = 'john@example.com';
$user->save();
```

## Updating Data
To update an existing record:
```php
$user = User::find(1);
$user->name = 'Jane Doe';
$user->save();
```

## Deleting Data
To delete a record:
```php
$user = User::find(1);
$user->delete();
```

## Query Builder
VrtMVC provides a simple query builder:
```php
$users = User::where('status', 'active')->get();
```

## Summary
- Models represent database tables
- Extend the base `Model` class
- Use built-in methods for CRUD operations
- Utilize query builder for advanced queries

