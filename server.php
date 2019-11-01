#!/usr/local/bin/php
<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/signal.php';

use AI\backend_php_hw4\UnixSockets\Server;

set_time_limit(0);

try {
    $App = new Server('server.ini');
} catch (Exception $e) {
    exit("Невозможно запустить сервер: ".$e->getMessage().PHP_EOL);
}

initSignal();

try {
    $App->raise();
    $App->run();
} catch (Exception $e) {
    $App->errorLog->add($e->getMessage());
    echo $e->getMessage().PHP_EOL;
}