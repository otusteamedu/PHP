<?php

namespace Otus\Utils;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Rabbit
 * @package Otus\Utils
 */
class Rabbit
{

    /**
     * Send message to rabbit
     * @param $list
     * @param $message
     * @throws \Exception
     */
    public static function sendMesage($list, $message)
    {
        $host = getenv('RABBIT_HOST');
        $user = getenv('RABBIT_USER');
        $pass = getenv('RABBIT_PASSWORD');
        $port = getenv('RABBIT_PORT');

        $connection = new AMQPStreamConnection($host, $port, $user, $pass);
        $channel = $connection->channel();
        $channel->queue_declare($list, false, true, false, false);
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $list);
        $channel->close();
        $connection->close();
    }
}