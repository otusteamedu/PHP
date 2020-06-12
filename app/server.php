<?php

use App\Exceptions\SocketException;
use App\Server;

require_once __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__.'/config.php';
$server = new Server($config['socketAddress']);
try {
    $server->createSocket();
}catch (SocketException $e){
    echo $e->getMessage();
}