# Getting Started with VrtMVC

## Introduction
Welcome to VrtMVC! This guide will walk you through setting up your first project and using the framework efficiently.

## Prerequisites
Before proceeding, ensure that you have installed VrtMVC by following the [Installation Guide](installation.md).

## Creating a New Project
Once VrtMVC is installed, you can start a new project by setting up the necessary configurations.

1. **Run the Install Script**
   ```bash
   ./install
   ```
   Follow the on-screen prompts to configure the framework.

2. **Verify Your Environment**
   - Ensure `.env` file is properly configured.
   - Check database connection settings if using MySQL instead of SQLite.

3. **Start the Development Server**
   ```bash
   ./vrtcli serve
   ```
   Open your browser and navigate to:
   ```
   http://localhost:8000/
   ```
   If everything is set up correctly, you should see the VrtMVC welcome page.

## Creating Your First Route
VrtMVC provides an easy way to define routes. Open `routes/web.php` and add:
```php
Route::get('/hello', function() {
    return 'Hello, VrtMVC!';
});
```
Now, visit:
```
http://localhost:8000/hello
```
You should see "Hello, VrtMVC!" displayed in your browser.

## Generating a Controller
To create a new controller, run:
```bash
./vrtcli make:controller SampleController
```
This will generate `SampleController.php` in `src/Controllers`.

## Creating a View
Use the CLI to generate a new view:
```bash
./vrtcli make:view sample
```
This will create `sample.php` inside `src/Views`.

## To generate a Controller and its View
Use the command:
```bash
./vrtcli make:conview Sample
```
This will generate the SampleController.php and sample.php each at its respective folders.

## To delete a Controller
Run the command:
```bash
./vrtcli destroy:controller SampleController
```
The SampleController.php file will be deleted from `src/Controllers`.

## To delete a View
Run the command:
```bash
./vrtcli destroy:view sample
```
The sample.php file will be deleted from `src/Views`.

## To delete a Controller and its View together
Run the command:
```bash
./vrtcli destroy:conview Sample
```
The SampleController.php file will be deleted.
Notice the 's' and 'S' in both creation and deletion actions.

## Next Steps
- Learn about [Routing](routing.md)
- Explore [Controllers](controllers.md)
- Understand [Models](models.md)
- Work with [Views](views.md)

Gone through all the steps? If yes, now you're ready to start building with VrtMVC! Happy coding.

