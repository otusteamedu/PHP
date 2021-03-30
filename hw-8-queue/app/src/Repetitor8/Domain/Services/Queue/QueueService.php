<?php


namespace Repetitor8\Domain\Services\Queue;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueService
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function receive(): void
    {
        $this->setChannelConnection();

        $this->channel->queue_declare(
            $_ENV['RABBITMQ_QUEUE'],
            false,
            false,
            false,
            false
        );

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $this->channel->basic_consume(
            $_ENV['RABBITMQ_QUEUE'],
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

    public function send(string $inputMessage): void
    {
        $this->setChannelConnection();

        $this->channel->queue_declare(
            $_ENV['RABBITMQ_QUEUE'],
            false,
            false,
            false,
            false
        );

        $msg = new AMQPMessage($inputMessage);
        $this->channel->basic_publish(
            $msg,
            '',

            // TODO: small fix-question: routing-key
//            'hello',
            $_ENV['RABBITMQ_QUEUE']
        );

        echo " [x] Sent $inputMessage\n";

        $this->closeChannelConnection();
    }

    private function setChannelConnection(): void
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_USER'],
            $_ENV['RABBITMQ_PASSWORD']
        );
        $this->channel = $this->connection->channel();
    }

    private function closeChannelConnection(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}