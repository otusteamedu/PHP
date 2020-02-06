<?php
require __DIR__ . '/bootstrap.php';

$factory = new \Socket\Raw\Factory();
// create stream connection socket server
$socket = $factory->createClient(getenv('SOCKET_PATH') ?: 'unix:///socks/server.sock');

while (true) {
    $data = fgets(STDIN);
    $socket->send($data, MSG_EOF);
}

$socket->close();
