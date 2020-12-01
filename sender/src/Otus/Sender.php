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


    public function __construct(string $host, int $port, string $user, string $password, int $channelId, string $queue)
    {
        $this->connect = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connect->channel($channelId);
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->queue = $queue;
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