<?php


namespace Otus;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;

class Receiver
{
    private AMQPChannel $channel;
    private string $queue;

    public function __construct(string $host, int $port, string $user, string $password, int $channelId, string $queue)
    {
        echo "Подключение..";
        for ($i = 0; $i < 30; $i++) {
            echo ".";
            try {
                $connect = new AMQPStreamConnection($host, $port, $user, $password);
                $this->channel = $connect->channel($channelId);
                $this->declareQueue($queue);
                echo "\nПодключено!\n";
                break;
            } catch (AMQPConnectionClosedException $e) {
                sleep(1);
            }
        }
    }


    private function declareQueue(string $queue): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->queue = $queue;
    }


    public function handler(callable $callback)
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}