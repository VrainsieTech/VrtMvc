# Installation Guide

## Requirements
Before installing VrtMVC, ensure that your system meets the following requirements:

- **PHP 7.4 or Higher**
- **Composer** (Dependency Management)
- **PDO & MySQL Extensions**(Not a must but recommended)

## Installation Steps
### 1. Install VrtMVC via Composer
Run the following command to install the framework:
```bash
composer create-project vrainsietech/vrtmvc my-new-project
```

### 2. Run the Installation Script
After installation, initialize the framework by running:
```bash
./install
```
Follow the prompts to configure your project.

### 3. Configure the Database
By default, VrtMVC uses **SQLite** for development, but you can switch to **MySQL** for production:
- To use MySQL, edit the `.env` file and update default database settings.
- To modify the connection dynamically, use:
  ```php
  config::set('database.default'='mysql');
  ```

### 4. Project Structure Overview
Once installed, your project will have the following structure:
```
/docs
/src
  ├── Controllers/   # Application controllers
  ├── Models/        # Database models
  ├── Views/         # Templating engine views
/public             # Public assets (CSS, JS, Images)
/routes             # Application routes
/config             # Configuration files
```

### 5. Start the Development Server
Run the built-in development server with:
```bash
./vrtcli serve
```
Then visit:
```
http://localhost:8000/
```

Your VrtMVC project is now set up and ready for development!

---

For more advanced configurations, check the [Configuration Guide](configuration.md).

