<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

// create exchange with name='logs' and type='fanout'
$channel->exchange_declare('logs', 'fanout', false, false, false);

// get queue name from declared exchange
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
// bing this queue to exchange
$channel->queue_bind($queue_name, 'logs');

echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

// configure consumption (no acknowledgement) 
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();