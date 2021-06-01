<?php
declare(strict_types=1);

namespace App\Clients;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class RabbitClient
{
    private const EXCHANGE = 'router';

    private const QUEUE = 'messages';

    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var AMQPChannel
     */
    private AMQPChannel $channel;

    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->connection = new AMQPStreamConnection($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD']);
        $this->channel = $this->connection->channel();

        $this->channel->queue_declare(self::QUEUE, false, true, false, false);
        $this->channel->exchange_declare(self::EXCHANGE, AMQPExchangeType::DIRECT);

        $this->channel->queue_bind(self::QUEUE, self::EXCHANGE);
    }

    /**
     * @param string $message
     *
     * @return void
     *
     * @throws Exception
     */
    public function dispatch(string $message): void
    {
        $message = new AMQPMessage($message, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $this->channel->basic_publish($message, '',self::QUEUE);
    }

    /**
     * @return string
     */
    public function consume(): string
    {
        $callback = function ($message)
        {
            echo "\n--------\n";
            echo $message->body;
            echo "\n--------\n";

            $message->ack();
        };

         return $this->channel->basic_consume(self::QUEUE, '', false, false, false, false, $callback);
    }

    public function wait()
    {
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
