<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../settings.php';

use Sockets\Server;

try {
    $server = new Server(SOCKET_FILE_PATH, LENGTH_MESSAGE);
    $server->listen();
} catch (\Exception $e) {
    echo $e->getMessage();
}