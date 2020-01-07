<?php
require "vendor/autoload.php";

use Ushakov\Server;

set_time_limit(0);
$socketFile = __DIR__ . "/server.sock";
try {
    $server = new Server($socketFile);
    $server->waitForClient();
    echo "Got new connection" . PHP_EOL;
    $i = 0;
    while (($clientMessage = $server->receiveMessage()) !== Server::QUIT_MESSAGE) {
        echo "Received message: " . $clientMessage;
        $server->sendMessage((++$i) . " messages were received");
    }
    echo "Client has closed connection." . PHP_EOL;
    $server->closeConnection();

} catch (\Exception $exception) {
    die($exception->getMessage());
}
