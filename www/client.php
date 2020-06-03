<?php

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/Configs/env.php';
include_once __DIR__ . '/Classes/Client.php';

try{
    set_time_limit(0);

    $client = new Classes\Client(getenv('SOCKET_ADDRESS'), getenv('SOCKET_PORT'));        

    $msg = fgets(STDIN);

    if (!empty($msg)) {
        echo "send: " . $client->send($msg);
        echo $client->response() . "\n";
    } 
} catch (Exception $ex) {
    echo $ex->getMessage();
}
