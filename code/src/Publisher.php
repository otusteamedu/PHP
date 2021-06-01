<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $connection = new AMQPStreamConnection(
        $_ENV['RABBIT_CONTAINER_NAME'],
        $_ENV['RABBIT_PORT'],
        $_ENV['RABBIT_USER'],
        $_ENV['RABBIT_PASS']
    );
    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, true);

    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    $callback = function ($msg) {
        echo ' [x] Sending message to ', $msg->body, "\n";
        $send = mail($msg->body, 'rabbit', 'Message from rabbit queue');
        if ($send) {
            echo 'The message has sent';
        } else {
            echo 'Error of message sending';
        }
    };

    $channel->basic_consume('hello', '', false, true, false, false, $callback);

    while ($channel->is_open()) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
