<?php

return [
    'hosts' => [
        $_ENV['ELASTIC_HOST'] ?? 'localhost:9200',
    ]
];
