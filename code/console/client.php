<?php

use Penguin\Sockets\Client;

require '../bootstrap.php';

try {
    $client = new Client($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $client->run();
} catch (Exception $error) {
    echo $error->getMessage();
}



