<?php
// Check if run from CLI
if (php_sapi_name() !== 'cli') {
    die('This script must be run from the command line.');
}

function loader($dots){
    $char = '.';
    $delay = 1;

        if($dots > 0){
            sleep($delay);
            echo $char;
            $dots--;
            loader($dots);
        }

}

function banner(){
    return "
#############################################################################
#############################################################################
     **       ** *****     ********  **         ** **       **   ********
      **     **  **   **   ********  ***       ***  **     **   ********
       **   **   **   **      **     ****     ****   **   **   **
        ** **    *****        **     **  ** **  **    ** **    **
         ***     **   **      **     **    *    **     ***      ********
          *      **    **     **     **         **      *        ********
#############################################################################
#############################################################################

    ";
}

echo "Welcome to VrtMVC Installer.\n";
sleep(1);
echo "Initializing "; loader(3); echo "\n";
sleep(1);
echo banner(); echo "\n";
sleep(1);

echo "Starting installation "; loader(3); echo "\n";

// 1. Create .env file (if it doesn't exist)
if (!file_exists('.env')) {
    echo "Creating .env file "; loader(3); echo "\n";
    copy('.env.example', '.env'); // Copy from example file
} else {
    echo ".env file already exists.\n";
    $consent = readline("Do you wish to create a new one? [Y/N]: ");
    if($consent == 'y' || $consent == 'yes'){
        unlink('.env');
        copy('.env.example', '.env'); 
        echo "New .env File Created Successfully.\n";
    } else {
        echo "Stopping Install "; loader(8); echo "\n";
        echo "Installation process stopped. Using previous install.\n";
        exit(1);
    }
}

// 2. Set Application Key
$key = bin2hex(random_bytes(32));
$envFile = file_get_contents('.env');
$envFile = preg_replace('/APP_KEY=/', 'APP_KEY=' . $key, $envFile);
$appName = readline("Enter App Name (default: My Application): ");
$envFile = preg_replace('/APP_NAME=/','APP_NAME='.($appName ?: 'My Application'), $envFile);
//Default Dev Mode Debug is True

$envFile = preg_replace('/APP_DEBUG=/','APP_DEBUG=true', $envFile);
file_put_contents('.env', $envFile);
echo "Application Name and Key set.\n";


// 3. Database Configuration
$dbHost = readline("Database Host (default: localhost): ");
$dbName = readline("Database Name: ");
$dbUser = readline("Database User: ");
$dbPassword = readline("Database Password: ");

$envFile = file_get_contents('.env');
$envFile = preg_replace('/DB_HOST=/', 'DB_HOST=' . ($dbHost ?: 'localhost'), $envFile);
$envFile = preg_replace('/DB_NAME=/', 'DB_NAME=' . $dbName, $envFile);
$envFile = preg_replace('/DB_USER=/', 'DB_USER=' . $dbUser, $envFile);
$envFile = preg_replace('/DB_PASS=/', 'DB_PASS=' . $dbPassword, $envFile);
file_put_contents('.env', $envFile);

echo "Database configuration updated in .env.\n";

// 4. Run Migrations (if applicable)
if (file_exists('vrtcli')) { // Check if you have an artisan-like command
    echo "Running database migrations...\n";
    passthru('php vrtcli migrate'); // Or your framework's migration command
} else {
    echo "No migrations found.\n";
}

// 5. Email Configuration
$mailUser = readline("Mail Username (your_mailtrap_username): ");
$mailPass = readline("Mail Password (your_mailtrap_password): ");
$mailAddr = readline("Mail From Address (default: hello@example.com): ");
$mailName = readline("Mail From Name(default: Example): ");

$envFile = file_get_contents('.env');
$envFile = preg_replace('/MAIL_USERNAME=/', 'MAIL_USERNAME=' . $mailUser, $envFile);
$envFile = preg_replace('/MAIL_PASSWORD=/', 'MAIL_PASSWORD=' . $mailPass, $envFile);
$envFile = preg_replace('/MAIL_FROM_ADDRESS=/', 'MAIL_FROM_ADDRESS=' . $mailAddr, $envFile);
$envFile = preg_replace('/MAIL_FROM_NAME=/', 'MAIL_FROM_NAME=' . $mailName, $envFile);
file_put_contents('.env', $envFile);

echo "Email Sender Configuration updated in .env. \n";

// 6. Set Storage Permissions
if (is_dir('storage')) {
    echo "Setting storage permissions...\n";
    chmod('storage', 0755); // Or a more restrictive permission if needed
    chmod('bootstrap/cache', 0755);
}

echo "Installation complete!\n";