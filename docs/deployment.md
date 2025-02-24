# Deploying VrtMVC Applications

## Overview
VrtMVC applications can be deployed on various hosting environments, including shared hosting, VPS, and cloud services. This guide covers the steps to prepare and deploy your VrtMVC application.

## Prerequisites
Ensure the following are installed on your server:
- PHP 7.4 or higher
- Composer
- Web server (Apache or Nginx)
- Database (MySQL, PostgreSQL, or SQLite)

## Deployment Steps

### 1. Uploading Your Application
- Use FTP/SFTP to upload your project files to the server.
- Alternatively, use Git to pull your project from a repository:
  ```bash
  git clone https://github.com/your-repo/vrtmvc-app.git
  ```

### 2. Installing Dependencies
After uploading, navigate to the project directory and install dependencies:
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Configuring the Environment
- Update database credentials and other settings in the `.env` file.
That is if there is need for that or, if you can run `./install` do it to save you the time.
Be sure to change the `APP_ENV` to 'production' once done. 

Or:
Dynamically apply changes on runtime with dynamic config setting. If not sure how, check [Configuration](configuration.md)

### 4. Setting File Permissions
Ensure correct file permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Setting Up the Web Server
#### Apache Configuration
Create a virtual host entry:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/vrtmvc-app/public
    <Directory /var/www/vrtmvc-app/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Enable the site and restart Apache:
```bash
a2ensite yourdomain.com.conf
systemctl restart apache2
```

#### Nginx Configuration
For Nginx, update your configuration:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/vrtmvc-app/public;
    index index.php index.html;

    location / {
        try_files $uri /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```
Restart Nginx:
```bash
systemctl restart nginx
```

### Cpanel Configuration
For Cpanel:
- Login to your account.
- Locate and open filemanager.
- Open the public folder.
- With your easiest way, upload your files.
- Extract and do any changes in the `.env` if you are not able to access CLI.
- Create `index.php` at the root of `public` and edit it to point to your app's entry point.


### 6. Running Migrations
Migrate the database:
```bash
./vrtcli migrate
```

### 7. Caching Configurations
Optimize the configuration and routes:
```bash
./vrtcli config:cache
./vrtcli route:cache
```

### 8. Running the Application
Start the application server if needed:
```bash
./vrtcli serve
```
Or access it through your domain.

For some cases, accessing CLI on cpanel is always hard or confusing for begginers, in this case if you are not able to, just run all the needed CLI commands on your local working environment then when you truly are sure you are ready for production, edit the `APP_ENV` and set it to `production` you can always edit it anywhere though. 

Create a zip for your project and upload it to cpanel.

## Summary
- Upload files and install dependencies.
- Configure environment settings and permissions.
- Set up the web server (Apache/Nginx).
- Run database migrations and cache optimizations.
- Start the application and verify deployment.

