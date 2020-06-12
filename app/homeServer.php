<?php

use App\Server;

require_once __DIR__ . '/vendor/autoload.php';

$responseAddress = __DIR__.'/my.sock';
$workServer = new Server($responseAddress);
try {
    $workServer->createSocket();
}catch (\App\Exceptions\SocketException $e){
    echo $e->getMessage();
}