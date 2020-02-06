<?php
require __DIR__ . '/bootstrap.php';

$factory = new \Socket\Raw\Factory();
// create stream connection socket server
$socket = $factory->createClient(getenv('SOCKET_PATH') ?: 'unix:///socks/server.sock');

while (true) {
    
    echo 123;
    sleep(10);
}
