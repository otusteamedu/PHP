<?php

require_once 'vendor/autoload.php';

$server = new \Astrviktor\Training\SocketMessenger\SocketServer();

echo $server->startmsg();

while (true) {
    $message = $server->run();
    echo $message;
}