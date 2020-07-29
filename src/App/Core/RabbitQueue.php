<?php

namespace Ozycast\App\Core;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Работа с очередями через RabbitMQ
 *
 * Class RabbitQueue
 * @package Ozycast\App\Core
 */
class RabbitQueue implements Queue
{
    /**
     * @var AMQPStreamConnection
     */
    public $connect = null;

    /**
     * @return Queue
     */
    public function connect(): Queue
    {
        if ($this->connect) {
            return $this;
        }

        $host = $_ENV["QUEUE_HOST"];
        $port = $_ENV["QUEUE_PORT"];
        $username = $_ENV["QUEUE_USER"];
        $password = $_ENV["QUEUE_PASSWORD"];

        $this->connect = new AMQPStreamConnection($host, $port, $username, $password);
        return $this;
    }

    /**
     * @param string $id
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel($id)
    {
        $channel = $this->connect->channel();
        $channel->queue_declare($id, false, true, false, false);
        return $channel;
    }

    /**
     * @param AMQPChannel $channel
     * @param string $queue
     * @param string $message
     */
    public function send($channel, $queue, string $message)
    {
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, "", $queue);
    }

    /**
     * @param string $channel
     * @param string $queue
     */
    public function addConsumer($channel, $queue)
    {
        $channel->basic_consume($queue, '', false, true, false, false, function ($msg) {
            RouteQueue::dispatch($msg->body);
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}