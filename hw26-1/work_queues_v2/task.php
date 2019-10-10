<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$datas = [
    '01_1s.',
    '02_2s..',
    '03_3s...',
    '04_4s....',
    '05_5s.....',
    '06_1s.',
    '07_2s..',
    '08_3s...',
    '09_4s....',
    '10_5s.....',
];

$msg = new AMQPMessage();

foreach ($datas as $data) {
    $msg->setBody($data);
    $channel->basic_publish($msg, '', 'hello');
}

$channel->close();
$connection->close();
