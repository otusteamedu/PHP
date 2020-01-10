<?php

use UnixSockets\Client;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/config.php';


try {
    $client = (new Client($config['socket_file_path']))->connect();
    $client->ping($argv[1]);
    // echo 'Message #1 sent';
    // sleep(5);
    // $client->ping('Message #2');
    // echo 'Message #2 sent';
    // sleep(10);
    // $client->ping('Message #3');
    // echo 'Message #3 sent';
} catch (\Exception $e) {
    echo $e->getMessage();
}