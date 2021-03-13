<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Otushw\Queue\QueueConnectionInterface;

class RabbitMQConnection implements QueueConnectionInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function connect(): void
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['queue']['host'],
            $_ENV['queue']['port'],
            $_ENV['queue']['user'],
            $_ENV['queue']['password']
        );
        $this->channel = $this->connection->channel();
    }

    public function disconnect(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

}