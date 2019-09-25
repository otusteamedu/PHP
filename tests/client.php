<?php

use UnixSockets\Client;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/config.php';

try {
    $client = (new Client($config['socket_file_path']))->connect();
    $client->ping('Message #1');
    sleep(5);
    $client->ping('Message #2');
    sleep(10);
    $client->ping('Message #3');
} catch (\Exception $e) {
    echo $e->getMessage();
}