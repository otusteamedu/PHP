<?php
include 'vendor/autoload.php';

use asterisk\daemon;

$params = [
    'server' => '127.0.0.1',
    'port'   => 5080,
    'user'   => 'amiuser',
    'pass'   => 'amipass',
    'events' => [
        'Newexten' => [
            'callback' => function ($data) {
                echo "New call \n";
                print_r($data);
            },
        ],
    ],
];
$server = new daemon($params);
$server->run();
