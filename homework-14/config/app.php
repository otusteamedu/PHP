<?php

return [
    'default' => $_ENV['DB_CONNECTION'] ?? 'mysql',
    'connections' => [
        'mysql' => [
            'host'     => $_ENV['DB_HOST'] ?? 'mysql',
            'port'     => $_ENV['DB_PORT'] ?? 3306,
            'database' => $_ENV['DB_DATABASE'] ?? 'default',
            'username' => $_ENV['DB_USERNAME'] ?? 'mysql',
            'password' => $_ENV['DB_PASSWORD'] ?? 'mysql',
        ],
        'pgsql' => [
            'host'     => $_ENV['DB_HOST'] ?? 'postgres',
            'port'     => $_ENV['DB_PORT'] ?? 5432,
            'database' => $_ENV['DB_DATABASE'] ?? 'default',
            'username' => $_ENV['DB_USERNAME'] ?? 'postgres',
            'password' => $_ENV['DB_PASSWORD'] ?? 'postgres',
        ],
        'sqlite' => [
            'database' => $_ENV['DB_DATABASE'] ?? ':memory:',
        ],
    ],
];
