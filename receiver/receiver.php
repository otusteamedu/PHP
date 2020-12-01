<?php


use Otus\Receiver;

require_once __DIR__ . "/vendor/autoload.php";


$receiver = new Receiver('localhost', 5672, 'otus', 'otus', 123, "hello");
$callback = function ($msg) {
    echo PHP_EOL . $msg->body . PHP_EOL;
};
$receiver->handler($callback);