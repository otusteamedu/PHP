<?php


namespace Otus;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;

class Receiver
{
    private AMQPChannel $channel;
    private string $queue;

    public function __construct()
    {
        echo "Подключение.." . PHP_EOL;
        try {
            $connect = new AMQPStreamConnection(
                $_ENV["RABBITMQ_DOCKER_HOST"],
                $_ENV["RABBITMQ_PORT"],
                $_ENV["RABBITMQ_USER"], $_ENV["RABBITMQ_PASS"]
            );
            $this->channel = $connect->channel($_ENV["RABBITMQ_CHANNEL"]);
            $this->declareQueue($_ENV["RABBITMQ_QUEUE"]);
            echo "Подключено!" . PHP_EOL;;
        } catch (AMQPConnectionClosedException $e) {
            echo "Ошибка подключения :(" .PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }


    private function declareQueue(string $queue): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->queue = $queue;
    }


    public function run()
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            function ($msg) {
                echo $msg->body . PHP_EOL;
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}