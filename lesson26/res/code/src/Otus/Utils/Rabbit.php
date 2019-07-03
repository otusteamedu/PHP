<?php

namespace Otus\Utils;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbit
{

    public static function sendMesage($list, $message)
    {
        $host = getenv('RABBIT_HOST');
        $user = getenv('RABBIT_USER');
        $pass = getenv('RABBIT_PASSWORD');

        $connection = new AMQPStreamConnection($host, 5672, $user, $pass);
        $channel = $connection->channel();
        $channel->queue_declare($list, false, true, false, false);
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $list);
        $channel->close();
        $connection->close();
    }
}