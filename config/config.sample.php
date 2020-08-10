<?php

return (object) [
    // Конфиг соединения с MongoDB
    'mongo' => (object) [
        'uri' => '',
        'uriOptions' => [],
        'driverOptions' => []
    ],

    // Конфиг соединения с youtube API
    'youtube' => (object) [
        'apiKey' => ''
    ],

    // Конфиг соединения с БД Redis
    'redis' => (object) [
        'host' => '',
        'port' => '',
        'password' => ''
    ]
];