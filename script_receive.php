<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
$channel = $connection->channel();

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
        $e->getMessage();
    }
}

try {
    $channel->close();
    $connection->close();
} catch (Exception $e) {
    echo $e->getCode() . ' file ' . $e->getFile();
}