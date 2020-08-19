<?php

use Penguin\Sockets\Server;

require '../bootstrap.php';

try {
    $server = new Server($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
    $server->run();
} catch (Exception $error) {
    echo $error->getMessage();
}

