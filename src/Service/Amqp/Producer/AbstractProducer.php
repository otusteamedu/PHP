<?php declare(strict_types=1);

namespace Service\Amqp\Producer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Service\Amqp\PublisherInterface;
use Service\Config\AmqpConfigProvider;

abstract class AbstractProducer implements PublisherInterface
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $configProvider = new AmqpConfigProvider('../config/config.ini');
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

    public function publish(string $message): void
    {
        $AMQPMessage = new AMQPMessage($message, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $this->channel->basic_publish($AMQPMessage, $this->getExchangeName());

        $this->channel->close();
        $this->connection->close();
    }

    abstract protected function getExchangeName(): string;

    abstract protected function getQueueName(): string;
}
