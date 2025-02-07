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
- Copy `.env.example` to `.env`:
  ```bash
  cp .env.example .env
  ```
- Update database credentials and other settings in the `.env` file.

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

## Summary
- Upload files and install dependencies.
- Configure environment settings and permissions.
- Set up the web server (Apache/Nginx).
- Run database migrations and cache optimizations.
- Start the application and verify deployment.

