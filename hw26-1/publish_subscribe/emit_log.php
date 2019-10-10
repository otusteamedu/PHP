<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

// create exchange with name='logs' and type='fanout'
$channel->exchange_declare('logs', 'fanout', false, false, false);

foreach(['one', 'two', 'three'] as $data) {
    $msg = new AMQPMessage($data);
    // instead of queue name, use here exchenge name='logs'
    $channel->basic_publish($msg, 'logs');
}

$channel->close();
$connection->close();
