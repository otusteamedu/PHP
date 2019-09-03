<?php

use APankov\Socket;

require_once "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$client = new Socket(getenv('SOCKET_HOST'), getenv('SOCKET_PORT'));
$serverMsg = null;

while ($serverMsg != getenv('SOCKET_DISCONNECT_COMMAND_CLIENT')) {
    $serverMsg = $client->readMsg();

    echo 'Server: ' . $serverMsg . PHP_EOL;
    echo 'Client: ';

    $msg = readline();
    $client->sendMsg($msg);
}