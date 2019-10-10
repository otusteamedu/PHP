<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange_name = 'direct_logs';
$exchange_type = 'direct';

// connect
$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

// exchange
$channel->exchange_declare($exchange_name, $exchange_type, false, false, false);

// messages
$msg = new AMQPMessage();
$msg->setBody('A1');
$channel->basic_publish($msg, $exchange_name, 'critical');
$msg->setBody('A2');
$channel->basic_publish($msg, $exchange_name, 'major');
$msg->setBody('A3');
$channel->basic_publish($msg, $exchange_name, 'minor');

// close
$channel->close();
$connection->close();
