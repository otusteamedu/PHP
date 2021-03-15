<?php

use \Otus\Socket\Server as Server;

require_once 'init.php';

try {
    $server = new Server(
        $_ENV['SOCKET_PATH'],
        $_ENV['SOCKET_PORT']
    );

    $server->listen();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}