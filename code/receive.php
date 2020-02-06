<?php
require __DIR__ . '/bootstrap.php';

$factory = new \Socket\Raw\Factory();
// create stream connection socket server
$socket = $factory->createServer(getenv('SOCKET_PATH') ?: 'unix:///socks/server.sock');

while ($connect = $socket->accept()){
    while ($data = $connect->read(1024)) {
        echo $data;
    }
    $connect->close();
}

$socket->close();
