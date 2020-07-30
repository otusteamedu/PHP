<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dbConfig = $dotenv->load();

return [
    'driver' => $dbConfig['DB_DRIVER'],
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'db_connection' => $dbConfig['DB_CONNECTION'],
            'db_host' => $dbConfig['DB_HOST'],
            'db_port' => $dbConfig['DB_PORT'],
            'db_database' => $dbConfig['DB_DATABASE'],
            'db_username' => $dbConfig['DB_USERNAME'],
            'db_password' => $dbConfig['DB_PASSWORD'],
        ]
    ]
];
