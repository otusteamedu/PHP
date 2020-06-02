<?php
include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/Configs/env.php';
include_once __DIR__ . '/Servers/Socket.php';

try{
    set_time_limit(0);

    $server = new Servers\Socket(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));
    $server->listen();
} catch (Exception $ex) {
    echo $ex->getMessage();
}


