<?php

namespace Otus\Sockets;

require('model/Client.php');

$ini = parse_ini_file('conf.ini');

try {
    $client = new Client(
        $ini['host'],
        $ini['port']
    );

    $client->waitForMessage();

} catch (SocketsException $e) {
    echo 'Can not connect to server', PHP_EOL;
}
