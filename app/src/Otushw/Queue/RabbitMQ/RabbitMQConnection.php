<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Otushw\Queue\QueueConnectionInterface;

class RabbitMQConnection implements QueueConnectionInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private static $instance = null;

    private function __construct() { }

    private function __clone() { }

    private function __wakeup() { }

    public static function getInstance(): RabbitMQConnection
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        self::$instance = self::connect();
        return self::$instance;
    }

//    public function __construct()
//    {
//        $this->connect();
//    }

    public function __destruct()
    {
        self::$instance = null;
        $this->disconnect();
    }

    public function connect(): RabbitMQConnection
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['queue']['host'],
            $_ENV['queue']['port'],
            $_ENV['queue']['user'],
            $_ENV['queue']['password']
        );
        $this->channel = $this->connection->channel();
        return $this;
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

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

}