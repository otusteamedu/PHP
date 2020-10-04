<?php

return [
    'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
    'port' => $_ENV['REDIS_PORT'] ?? 6379,
    'password' => $_ENV['REDIS_PASSWORD'] ?? '',
];
