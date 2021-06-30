<?php

declare(strict_types=1);

namespace App\Service\Queue\RabbitMQ;

use App\Framework\Config\Configuration;
use App\Service\Queue\ConsumerInterface;
use App\Service\Queue\Exception\QueueConnectionException;
use App\Service\Queue\QueueClientInterface;
use App\Service\Queue\QueueMessage;
use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQQueueClient implements QueueClientInterface
{
    private Configuration         $config;
    private ?AMQPStreamConnection $queueConnection;
    /**
     * @var AMQPChannel[]
     */
    private array $channels = [];

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function connect(): void
    {
        if (empty($this->queueConnection)) {
            $this->queueConnection = new AMQPStreamConnection(
                $this->config->getParam('queue_host'),
                intval($this->config->getParam('queue_port')),
                $this->config->getParam('queue_username'),
                $this->config->getParam('queue_password')
            );
        }
    }

    /**
     * @throws QueueConnectionException
     */
    public function publish(string $queueName, $message): void
    {
        $this->throwExceptionIfIsNotConnected();

        $channel = $this->createChannel($queueName);

        $msg = new AMQPMessage(json_encode($message));
        $channel->basic_publish($msg, '', $queueName);

        $this->closeChannel($queueName);
    }

    /**
     * @throws QueueConnectionException
     */
    public function subscribe(string $queueName, ConsumerInterface $consumer): void
    {
        $this->throwExceptionIfIsNotConnected();

        $channel = $this->createChannel($queueName);

        $handler = function ($msg) use ($consumer) {
            /* @var AMQPMessage $msg */
            $consumer->consume(new QueueMessage($msg->getBody()));
        };

        $channel->basic_consume($queueName, '', false, true, false, false, $handler);
    }

    /**
     * @throws ErrorException
     * @throws QueueConnectionException
     */
    public function wait(string $queueName): void
    {
        $this->throwExceptionIfIsNotConnected();

        $channel = $this->createChannel($queueName);

        //while ($channel->is_consuming()) {
            $channel->wait();
//        }
    }

    /**
     * @throws Exception
     */
    public function disconnect(): void
    {
        $this->closeAllChannels();

        if ($this->isConnected()) {
            $this->queueConnection->close();
            $this->queueConnection = null;
        }
    }

    private function closeAllChannels(): void
    {
        foreach ($this->channels as $queueName => $channel) {
            $this->closeChannel($queueName);
        }
    }

    private function closeChannel(string $queueName): void
    {
        if (!empty($this->channels[$queueName])) {
            $this->channels[$queueName]->close();

            unset($this->channels[$queueName]);
        }
    }

    /**
     * @throws QueueConnectionException
     */
    private function throwExceptionIfIsNotConnected(): void
    {
        if (!$this->isConnected()) {
            throw new QueueConnectionException('Не установлено соединение с сервисом очередей');
        }
    }

    private function isConnected(): bool
    {
        return !empty($this->queueConnection);
    }

    private function createChannel(string $queueName): AMQPChannel
    {
        if (!empty($this->channels[$queueName])) {
            return $this->channels[$queueName];
        }

        $channel = $this->queueConnection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        return $this->channels[$queueName] = $channel;
    }
}