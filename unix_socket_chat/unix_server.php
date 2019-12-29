<?php
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;

$unix_worker = new Worker('unix://./unix.sock');

$unix_worker->count = 4;

$unix_worker->onMessage = function($connection, $data)
{
    $connection->send('Вы успешно отправили сообщение!');
    echo $data."\n";
};

Worker::runAll();