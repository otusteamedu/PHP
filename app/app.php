<?php

define('ROOT', dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/app.php';

use Otus\Http\App;
use Otus\Sockets\Exceptions\SocketException;
use Otus\Sockets\Server;
use Otus\Sockets\Client;

// 4.1
if ($argv[1] === '') {
    try {
        $app = new App();
        $app->run();
    } catch (Exception $e) {
        echo 'exception ' . $e;
    }
}

// 4.2
if ($argv[1] === 'server') {
    try {
        $server = new Server($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
        $server->listen();
    } catch (SocketException $e) {
        echo 'SocketException ' . PHP_EOL;
    }
}

if ($argv[1] === 'client') {
    try {
        $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
        $client->connect();
    } catch (SocketException $e) {
        echo 'SocketException ' . PHP_EOL;
    }
}