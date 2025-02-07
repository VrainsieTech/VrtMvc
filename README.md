# VrtMvc
Vrainsie Tech Model View Controller Library

# VrtMVC

## Overview
VrtMVC is a simple yet powerful and robust PHP framework that follows the MVC architecture. It provides a solid foundation for developers, eliminating the need to start projects from scratch.

### Why VrtMVC?
Many startups and upcoming developers want to follow the DRY (Don't Repeat Yourself) principle. However, repeatedly starting projects from the ground up is time-consuming. While frameworks like Laravel are great, they may be too heavy for simpler projects. **VrtMVC** provides a lightweight yet feature-rich alternative, allowing users to start at 65% completion.

---

## Features
- **Supports RESTful APIs**
- **Built-in Authentication** (Login, Register, Password Reset)
- **Custom Templating Engine**
- **Command-Line Interface (CLI)**
- **Lightweight SQLite for Development Testing**

---

## Installation & Setup
### Requirements
- **PHP 7 or Higher**
- **Composer** (for dependency management)
- **PDO & MySQL extensions** (Recommended, but not needed)

### Installation Steps
1. Install via Composer:
   ```bash
   composer create-projecct vrainsietech/vrtmvc my-new-project
   ```
2. Run the installation script:
   ```bash
   ./install
   ```
   Follow the prompts to configure your project.
3. Configure the database:
   - Default: **SQLite** for development
   - Production: **MySQL** (recommended, but not required)
4. Project Structure:
   - Add controllers to `src/Controllers`
   - Add views to `src/Views`
   - Place public assets in the `public/` folder

---

## Usage
### Basic "Hello World" Example
1. Generate a new view, controller, and route:
   ```bash
   ./vrtcli make:view helloworld -r
   ```
2. Start the development server:
   ```bash
   ./vrtcli serve
   ```
3. Open a browser and visit:
   ```
   http://localhost:8000/helloworld
   ```
   You should see:
   ```
   Hello, I am from helloWorld
   ```

### Routing
VrtMVC has a built-in router. To define routes, edit `routes/web.php`. Default routes are already included for customization.

---

## Configuration
- Initial setup happens during `./install`, which creates a `.env` file.
- Modify settings dynamically:
  ```php
  config::database(DB_CONNECTION='mysql');
  ```
  OR manually edit `.env` and the `config/` directory.

---

## Framework Architecture
VrtMVC follows the MVC structure:
- **Model**: Manages data and database interactions.
- **View**: Handles presentation logic.
- **Controller**: Acts as a middleman between Model and View.

The framework has its own **HTTP logic** to handle requests and responses efficiently. It follows **convention over configuration** to simplify development.

---

## Security
- **CSRF Protection**
- **XSS Prevention**
- **SQL Injection Protection**
- **Middleware for Authentication & Authorization**

---

## Extensibility
- Extend VrtMVC with additional packages.
- Compatible with third-party libraries.

---

## Deployment
- Can be deployed on **any web server**.
- Supports **shared hosting**.
- **PWA-ready**: Easily convertible to **TWA** for native Android apps or **Electron** for desktop applications.

---

## Contribution
- Contributions are welcome on **GitHub**.
- Submit **pull requests** and report **issues**.

---

## License
VrtMVC is open-source and licensed under the **MIT License**.

---

## Support
For support, contact **vrainsietech@gmail.com**.
A community platform (e.g., Discord/Telegram) will be created soon!


