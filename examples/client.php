#!/usr/bin/env php
<?php

declare(ticks=1);

use crazydope\socket\SocketFactory;

require '../vendor/autoload.php';

const SERVER_ADDRESS = 'tcp://127.0.0.1:1337';

$serverListening = true;

pcntl_signal(SIGTERM, 'sigHandler');
pcntl_signal(SIGINT, 'sigHandler');

function sigHandler()
{
    global $serverListening;
    echo 'Received quit signal, finishing tasks... ' . PHP_EOL;
    $serverListening = false;
}

$client = (new SocketFactory())->createClient(SERVER_ADDRESS);
echo 'Client connected to: ' . SERVER_ADDRESS . PHP_EOL;
echo trim($client->read(120)) . PHP_EOL;

while ($serverListening) {
    $msg = strtolower(trim(readline('Guess: ')));
    $client->write($msg . PHP_EOL);
    $replay = trim($client->read(1024, PHP_NORMAL_READ));
    echo 'Reply from server: ' . $replay . PHP_EOL;

    $serverClose = strrpos($replay, 'Bye');
    if ($serverClose !== false) {
        $serverListening = false;
    }
}

if ($serverClose === false) {
    $client->write('exit' . PHP_EOL);
}
$client->close();

