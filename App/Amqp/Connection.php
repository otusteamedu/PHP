<?php


namespace App\Amqp;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    public static function create(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            config('queue.host'),
            config('queue.port'),
            config('queue.user'),
            config('queue.password'),
        );

    }
}