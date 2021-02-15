<?php

use App\Client;
use App\Socket\Exceptions\SocketException;

require __DIR__ . '/../vendor/autoload.php';

$socketFile = $_ENV['SOCKET_DIR'] . '/' . $_ENV['SOCKET_FILE'];

try {
    $client = new Client($socketFile);

    $client->waitForMessage();

    $client = null;

} catch (SocketException $e) {
    echo 'Socket exception', PHP_EOL;
    echo $e->getMessage();
}

