<?php

require_once __DIR__ . '/../vendor/autoload.php';

use UnixSockets\Server;

$config = require_once __DIR__ . '/config.php';

try {
    $server = new Server($config['socket_file_path'], $config['message_length']);
    $server->listen();
} catch (\Exception $e) {
    echo $e->getMessage();
}