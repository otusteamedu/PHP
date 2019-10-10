<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange_name = 'topic_logs';
$exchange_type = 'topic';

// connect
$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

// exchange
$channel->exchange_declare($exchange_name, $exchange_type, false, false, false);

// messages
$msg = new AMQPMessage();
$msg->setBody('SA1');
$channel->basic_publish($msg, $exchange_name, 'system.critical');
$msg->setBody('SA2');
$channel->basic_publish($msg, $exchange_name, 'system.major');
$msg->setBody('SA3');
$channel->basic_publish($msg, $exchange_name, 'system.minor');
$msg->setBody('KA1');
$channel->basic_publish($msg, $exchange_name, 'kernel.critical');
$msg->setBody('KA2');
$channel->basic_publish($msg, $exchange_name, 'kernel.major');
$msg->setBody('KA3');
$channel->basic_publish($msg, $exchange_name, 'kernel.minor');

// close
$channel->close();
$connection->close();
