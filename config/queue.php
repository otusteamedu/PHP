<?php
return [
    'host'     => env('RABBIT_HOST'),
    'port'     => env('RABBIT_PORT', 5671),
    'user'     => env('RABBIT_USER', 'guest'),
    'password' => env('RABBIT_PASSWORD', 'guest')
];