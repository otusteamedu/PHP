<?php declare(strict_types=1);

namespace Service\Amqp\Consumer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractConsumer
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

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function run(): void
    {
        $this->channel->basic_consume(
            $this->getQueueName(),
            $this->getConsumerTag(),
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function processMessage(AMQPMessage $message)
    {
        $this->operate($message->getBody());
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }

    abstract public function operate(string $payload): void;

    abstract protected function getExchangeName(): string;

    abstract protected function getQueueName(): string;

    abstract protected function getConsumerTag(): string;
}
