<?php

use SayHelloApp\Server;

require_once __DIR__ . '/vendor/autoload.php';
$config = require_once __DIR__ . '/config.php';

try {
    $server = new Server($config['file']);
    $server->runDeamon();
} catch (Exception $e) {
    echo $e->getMessage();
}