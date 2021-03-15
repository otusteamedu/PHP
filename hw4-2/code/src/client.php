<?php

use Otus\Socket\Client as Client;

require_once 'init.php';

try {
    $client = new Client(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT']
    );

    echo 'Enter Your Message: '.PHP_EOL;

    $client->waitingForMessage();

    echo 'Waiting for Response' . PHP_EOL;

    $client->waitingForResponse();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}