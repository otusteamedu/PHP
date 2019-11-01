#!/usr/local/bin/php
<?php
require __DIR__.'/vendor/autoload.php';

use AI\backend_php_hw4\UnixSockets\Client;

set_time_limit(0);

try {
    $App = new Client('client.ini');
} catch (Exception $e) {
    exit("Невозможно запустить клиент: ".$e->getMessage().PHP_EOL);
}

try {
    $App->connect();
    $App->run();
} catch (Exception $e) {
    $App->errorLog->add($e->getMessage());
    echo $e->getMessage().PHP_EOL;
}

