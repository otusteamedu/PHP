<?php

use \Otus\Socket\Server as Server;

require_once 'init.php';

try {
    $socketPath = realpath(__DIR__ . '/../tmp') . '/' . $_ENV['SOCKET_FILE'];
    $server = new Server(
        $socketPath,
        $_ENV['SOCKET_PORT']
    );

    $server->listen();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}