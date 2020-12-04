<?php


namespace Otus;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{
    private AMQPChannel $channel;
    private AMQPStreamConnection $connect;
    private string $queue;


    public function __construct()
    {
        $this->connect = new AMQPStreamConnection(
            $_ENV["RABBITMQ_DOCKER_HOST"],
            $_ENV["RABBITMQ_PORT"],
            $_ENV["RABBITMQ_USER"],
            $_ENV["RABBITMQ_PASS"]
        );

        $this->channel = $this->connect->channel($_ENV["RABBITMQ_CHANNEL"]);
        $this->channel->queue_declare($_ENV["RABBITMQ_QUEUE"], false, true, false, false);
        $this->queue = $_ENV["RABBITMQ_QUEUE"];
    }


    public function __destruct()
    {
        $this->channel->close();
        $this->connect->close();
    }


    public function sendMessage(string $text): void
    {
        $msg = new AMQPMessage($text);
        $this->channel->basic_publish($msg, '', $this->queue);
    }
}