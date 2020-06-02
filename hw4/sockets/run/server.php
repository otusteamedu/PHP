<?php

use UxSockets\Log\Log;
use UxSockets\Server;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $server = new Server();
    $server->upServer();
    $server->sendAndRecieveMessage();
    $server->closeSocket();
} catch (Exception $e) {
    echo "Exception: {$e->getMessage()}" . PHP_EOL;
    $log = new Log($server->getConfig()->getSettings()["error_log"]);
    $log->addLogNote($e->getMessage());
    $server->closeSocket();
}
