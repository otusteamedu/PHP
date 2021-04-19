<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnection
{
    private static AMQPStreamConnection $connection;
    private static AMQPChannel $channel;
    private static $instance = null;

    private function __construct() { }

    private function __clone() { }

    private function __wakeup() { }

    public static function getInstanceChannel(): AMQPChannel
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        self::$instance = self::connect();
        return self::$instance;
    }

    public function __destruct()
    {
        self::$instance = null;
        $this->disconnect();
    }

    public function connect(): AMQPChannel
    {
        self::$connection = new AMQPStreamConnection(
            $_ENV['queue']['host'],
            $_ENV['queue']['port'],
            $_ENV['queue']['user'],
            $_ENV['queue']['password']
        );
        return self::$connection->channel();
    }

    public function disconnect(): void
    {
        self::$channel->close();
        self::$connection->close();
    }

}