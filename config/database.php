<?php

return [
        'default' => getenv('DB_CONNECTION', 'mysql'),
        'connections' => [
            'mysql' => [
                'host' => getenv('DB_HOST', 'localhost'),
                'port' => getenv('DB_PORT', 3306),
                'database' => getenv('DB_DATABASE'),
                'username' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
            'pgsql' => [ // Example for Postgres
                'host' => getenv('PGSQL_HOST', 'localhost'),
                'port' => getenv('PGSQL_PORT', 5432),
                'database' => getenv('PGSQL_DATABASE'),
                'username' => getenv('PGSQL_USERNAME'),
                'password' => getenv('PGSQL_PASSWORD'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ],
        ]
];