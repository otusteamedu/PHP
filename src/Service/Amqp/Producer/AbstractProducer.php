<?php declare(strict_types=1);

namespace Service\Amqp\Producer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractProducer
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'rabbitmq',
            'rabbitmq',
            '/'
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->getQueueName(), false, true, false, false);
        $this->channel->exchange_declare($this->getExchangeName(), AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->getQueueName(), $this->getExchangeName());
    }

    public function publish(string $payload): void
    {
        $message = new AMQPMessage($payload, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $this->channel->basic_publish($message, $this->getExchangeName());

        $this->channel->close();
        $this->connection->close();
    }

    abstract protected function getExchangeName(): string;

    abstract protected function getQueueName(): string;
}
