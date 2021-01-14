<?php

require '../vendor/autoload.php';

use Socket\Socket;
use Server\Server;
use Client\Client;

try {
//    $app = new Socket();
//    $app->run();

//    $server = new Server();
//    $server->start();
//
    $client = new Client();
    $client->start();

} catch (Exception $e) {
    echo $e->getMessage();
}
