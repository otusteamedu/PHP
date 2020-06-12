<?php
require __DIR__ . '/vendor/autoload.php';

use models\SocketServer;

set_time_limit(0);

try {
    $server = new SocketServer('/tmp/hw4.sock');
    $server->run();
} catch (Exception $e) {
    echo $e;
    exit();
}
