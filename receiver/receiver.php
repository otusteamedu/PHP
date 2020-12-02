<?php

use Otus\Receiver;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../.env");

try {
    $receiver = new Receiver();
    $receiver->run();
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
}