<?php declare(strict_types=1);

namespace Service\Amqp\Consumer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Service\Amqp\SubscriberInterface;
use Service\Config\AmqpConfigProvider;

abstract class AbstractConsumer implements SubscriberInterface
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $configProvider = new AmqpConfigProvider('config/config.ini');
        $this->connection = new AMQPStreamConnection(
            $configProvider->getHost(),
            $configProvider->getPort(),
            $configProvider->getUser(),
            $configProvider->getPassword(),
            $configProvider->getVHost()
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

    abstract public function operate(string $message): void;

    abstract protected function getExchangeName(): string;

    abstract protected function getQueueName(): string;

    abstract protected function getConsumerTag(): string;
}
