<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\RabbitMQ;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$channel = RabbitMQ::getAMQPChannel();

$channel->queue_declare('post_body_queue', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;

$callback = static function ($msg) {
    echo ' [x] Received ', $msg->body, PHP_EOL;
};

$channel->basic_consume('post_body_queue', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    try {
        $channel->wait();
    } catch (ErrorException $e) {
    }
}

try {
    RabbitMQ::closeChannelAndConnection();
} catch (Exception $e) {
}