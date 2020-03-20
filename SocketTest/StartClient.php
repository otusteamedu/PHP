<?php

require_once 'vendor/autoload.php';

$name = "Default";
if (isset($argv[1])) $name = $argv[1];

$client = new \Astrviktor\Training\SocketMessenger\SocketClient($name);

while (true) {
    echo $client->startmsg();
    $message = $client->run();

    if ($message) echo $message . PHP_EOL;
}