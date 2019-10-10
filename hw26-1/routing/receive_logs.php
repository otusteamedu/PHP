<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$exchange_name = 'direct_logs';
$exchange_type = 'direct';
$binding_keys = array_slice($argv, 1);
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [critical] [major] [minor]\n");
    exit(1);
}

// connect
$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

// exchange
$channel->exchange_declare($exchange_name, $exchange_type, false, false, false);

// queue
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
foreach ($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, $exchange_name, $binding_key);
}

echo " [*] Waiting for logs. To exit press CTRL+C\n";

// callback
$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

// consume 
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

// loop
while ($channel->is_consuming()) {
    $channel->wait();
}

// close
$channel->close();
$connection->close();