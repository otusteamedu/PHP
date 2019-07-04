#!/usr/bin/php
<?php

require_once 'vendor/autoload.php';

use Otus\Models\Message;
use Otus\Utils\Rabbit;
use PhpAmqpLib\Connection\AMQPStreamConnection;

putenv('RABBIT_HOST=127.0.0.1');
putenv('RABBIT_USER=rabbitmq');
putenv('RABBIT_PASSWORD=rabbitmq');
putenv('RABBIT_PORT=5672');
putenv('POSTGRES_HOST=127.0.0.1');
putenv('POSTGRES_USER=testuser');
putenv('POSTGRES_PASSWORD=testpassword');
putenv('POSTGRES_DB=test_db');
putenv('POSTGRES_SCHEMA=cinema');
putenv('POSTGRES_PORT=5433');
//get credits
$host = getenv('RABBIT_HOST');
$user = getenv('RABBIT_USER');
$pass = getenv('RABBIT_PASSWORD');
$port = getenv('RABBIT_PORT');

//declare list
$connection = new AMQPStreamConnection($host, $port, $user, $pass);
$channel = $connection->channel();
$channel->queue_declare(Message::getQueueName(), false, true, false, false);

/**
 * Callback function
 * @param $msg
 */
$callback = function ($msg) {
    $message = json_decode($msg->body);
    try {
        sleep(mt_rand(2, 20));
        $id = $message->id;
        $item = Message::findById($id);
        $item->status = mt_rand(Message::STATUS_ACCEPTED, Message::STATUS_REJECTED);
        $item->save();
    } catch (Exception $exc) {
        $message = (array)$message;
        if (array_key_exists('rebuild', $message)) {
            $message['rebuild'] = (int)$message['rebuild'] + 1;
        } else {
            $message['rebuild'] = 1;
        }
        $message = json_encode($message);
        //повторно отсылаем сообщение с фейлом
        Rabbit::sendMesage(Message::getQueueName(), $message);
    }
};
$channel->basic_consume(Message::getQueueName(), '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();