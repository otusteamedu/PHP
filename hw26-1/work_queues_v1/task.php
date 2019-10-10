<?php

require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$datas = [
    '01_10s..........',
    '02_2s..',
    '03_15s...............',
    '04_5s.....',
    '05_10s..........',
    '06_2s..',
    '07_9s.........',
    '08_4s....',
    '09_11s...........',
    '10_5s.....',
    '11_10s..........',
    '12_3s...',
];

$msg = new AMQPMessage();

foreach ($datas as $data) {
    $msg->setBody($data);
    $channel->basic_publish($msg, '', 'hello');
}

$channel->close();
$connection->close();
