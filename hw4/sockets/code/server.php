<?php

namespace Otus\Sockets;

require('model/Server.php');

$ini = parse_ini_file('conf.ini');

try {
    $server = new Server(
        $ini['host'],
        $ini['port']
    );

    $server->listen();

} catch (SocketsException $e) {
    echo 'SocketsException', PHP_EOL;
}