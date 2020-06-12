<?php

require_once __DIR__.'/vendor/autoload.php';

$requestAddress = __DIR__.'/my.sock';
$client = new \App\Client($requestAddress,'Worker');
try {
    $socket = $client->createSocket();
} catch (\App\Exceptions\SocketException $e) {
    echo $e->getMessage();
}
$client->startWrite($socket);