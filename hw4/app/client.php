<?php

use SayHelloApp\Client;

require_once __DIR__ . '/vendor/autoload.php';
$config = require_once __DIR__ . '/config.php';

$message = readline("Введите ваше имя или stop для остановки сервера: ");

try {
    $client = new Client($config['file']);
    echo $client->sendMessage($message);
} catch (Exception $e) {
    echo $e->getMessage();
}
