<?php
require_once '../bootstrap/bootstrap.php';
use \Monolog\Logger;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Logger\AppLogger;

try {
    $className = $argv[1];
    /** @var RabbitMQConsumer $consumer */
    $consumer = new $className();
    $consumer->start();
} catch (\Exception $exception) {
    AppLogger::addLog(Logger::ERROR, $exception->getMessage());
}