<?php

namespace App\Services;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;


final class RabbitMQ
{
    private static ?AMQPChannel $channel = null;
    private static ?AMQPStreamConnection $connection = null;

    private function __construct()
    {
    }

    public static function getAMQPChannel(): AMQPChannel
    {
        if (static::$channel === null) {
            static::$connection = self::getAMQPStreamConnection();
            static::$channel = static::$connection->channel();
        }

        return static::$channel;
    }

    private static function getAMQPStreamConnection(): AMQPStreamConnection
    {
        if (static::$channel === null) {
            static::$connection = new AMQPStreamConnection(
                $_ENV['RABBITMQ_HOST'],
                $_ENV['RABBITMQ_PORT'],
                $_ENV['RABBITMQ_USER'],
                $_ENV['RABBITMQ_PASSWORD']
            );
        }

        return static::$connection;
    }

    /**
     * @throws Exception
     */
    public static function closeChannelAndConnection(): void
    {
        static::$channel->close();
        static::$connection->close();

        static::$channel = null;
        static::$connection = null;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}