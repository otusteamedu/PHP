<?php

use Otus\Socket\Client as Client;

require_once 'init.php';

try {
    $socketPath = realpath(__DIR__ . '/../tmp') . '/' . $_ENV['SOCKET_FILE'];
    $client = new Client(
        $socketPath,
        $_ENV['SOCKET_PORT']
    );

    echo 'Enter Your Message: '.PHP_EOL;

    $client->waitingForMessage();

    echo 'Waiting for Response' . PHP_EOL;

    $client->waitingForResponse();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}