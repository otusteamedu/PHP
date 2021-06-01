<?php
declare(strict_types=1);

namespace Src;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    private AMQPChannel $channel;

    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBIT_CONTAINER_NAME'],
            $_ENV['RABBIT_PORT'],
            $_ENV['RABBIT_USER'],
            $_ENV['RABBIT_PASS']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hello');
    }

    /**
     * @throws \Exception
     */
    public function send($email)
    {
        $msg = new AMQPMessage($email);
        $this->channel->basic_publish($msg, '', 'hello');
        $this->channel->close();
        $this->connection->close();
    }

}