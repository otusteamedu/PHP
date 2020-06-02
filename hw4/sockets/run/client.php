<?php

use UxSockets\Client;
use UxSockets\Log\Log;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new Client();
    $client->connectToSocket();
    $client->sendMesssage("I greet You оn my Land!");
    $client->receiveMessage();
    $client->closeSocket();
} catch (Exception $e) {
    echo "Exception: {$e->getMessage()}" . PHP_EOL;
    $log = new Log($client->getConfig()->getSettings()["error_log"]);
    $log->addLogNote($e->getMessage());
}
