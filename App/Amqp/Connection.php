<?php


namespace App\Amqp;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    public static function create(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            getenv('RABBIT_HOST'),
            getenv('RABBIT_PORT'),
            getenv('RABBIT_USER'),
            getenv('RABBIT_PASSWORD')
        );

    }
}