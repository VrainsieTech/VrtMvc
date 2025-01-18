<?php

return [
    'mail' => [
        'default' => getenv('MAIL_MAILER', 'smtp'),
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => getenv('MAIL_HOST'),
                'port' => getenv('MAIL_PORT', 587),
                'encryption' => getenv('MAIL_ENCRYPTION', 'tls'),
                'username' => getenv('MAIL_USERNAME'),
                'password' => getenv('MAIL_PASSWORD'),
                'from' => [
                    'address' => getenv('MAIL_FROM_ADDRESS', 'hello@example.com'),
                    'name' => getenv('MAIL_FROM_NAME', 'Example'),
                ],
            ],
            'sendmail' => [
                'transport' => 'sendmail',
                'path' => '/usr/sbin/sendmail -bs',
            ],
            'mailgun' => [
                'transport' => 'mailgun',
                'domain' => getenv('MAILGUN_DOMAIN'),
                'secret' => getenv('MAILGUN_SECRET'),
                'endpoint' => getenv('MAILGUN_ENDPOINT', 'api.mailgun.net'),
            ],
            'postmark' => [
                'transport' => 'postmark',
                'token' => getenv('POSTMARK_TOKEN'),
            ],
            'ses' => [
                'transport' => 'ses',
                'key' => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
                'region' => getenv('AWS_DEFAULT_REGION', 'us-east-1'),
            ],
        ],
    ],
];