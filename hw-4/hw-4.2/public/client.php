<?php

use App\Exceptions\SocketsException;
use App\Client;

require __DIR__.'/../bootstrap.php';

try {

    $client = new Client(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT'],
    );

    $client->waitForMessage();

} catch (SocketsException $e) {
    echo 'Can not connect to server', PHP_EOL;
}
