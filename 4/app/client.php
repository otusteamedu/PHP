<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../settings.php';

use Sockets\Client;

try {
    $client = (new Client(SOCKET_FILE_PATH))->connect();

    while (true) {
        $line = trim(fgets(STDIN)); // читает одну строку из STDIN
        $client->ping($line);
    }



} catch (\Exception $e) {
    echo $e->getMessage();
}