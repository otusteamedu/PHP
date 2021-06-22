<?php
namespace Src;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher
{
    private AMQPChannel $channel;

    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBIT_HOST'],
            $_ENV['RABBIT_PORT'],
            $_ENV['RABBIT_USER'],
            $_ENV['RABBIT_PASSWORD']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('email-queue');
    }

    public function send($email)
    {
        $msg = new AMQPMessage($email);
        $this->channel->basic_publish($msg, '', 'email-queue');
        $this->closeConnection();
    }

    public function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }

}