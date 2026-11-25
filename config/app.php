<?php
/**
 * Centralized application configuration.
 * Values can be overridden via environment variables.
 */

return [
    'app_name' => 'Save Life Cancer Foundation',
    'db' => [
        'host' => getenv('HELPUS_DB_HOST') ?: 'localhost',
        'username' => getenv('HELPUS_DB_USER') ?: 'root',
        'password' => getenv('HELPUS_DB_PASS') !== false ? getenv('HELPUS_DB_PASS') : '1234',
        'name' => getenv('HELPUS_DB_NAME') ?: 'cancer',
        'charset' => 'utf8mb4',
    ],
    'smtp' => [
        'enabled' => getenv('HELPUS_SMTP_ENABLED') !== '0',
        'host' => getenv('HELPUS_SMTP_HOST') ?: 'smtp.gmail.com',
        'port' => (int)(getenv('HELPUS_SMTP_PORT') ?: 587),
        'encryption' => getenv('HELPUS_SMTP_SECURE') ?: 'tls',
        'username' => getenv('HELPUS_SMTP_USER') ?: 'savelifefoundationsl2@gmail.com',
        'password' => getenv('HELPUS_SMTP_PASS') ?: 'ywwelcmgxovhzxbp',
        'from_email' => getenv('HELPUS_SMTP_FROM') ?: 'savelifefoundationsl2@gmail.com',
        'from_name' => 'Save Life Cancer Foundation',
        'admin_notify_email' => getenv('HELPUS_ADMIN_EMAIL') ?: 'sanjubalasuriya@gmail.com',
    ],
    'uploads' => [
        'max_bytes' => 5 * 1024 * 1024, // 5 MB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
    ],
];
