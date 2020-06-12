<?php

use App\Client;
use App\Exceptions\SocketException;

require_once __DIR__.'/vendor/autoload.php';

$config = require_once __DIR__.'/config.php';
$client = new Client($config['socketAddress'],$config['clientName']);
try {
    $socket = $client->createSocket();
} catch (SocketException $e) {
    echo $e->getMessage();
}
$client->startWrite($socket);