<?php

namespace Otus\Consumer\RabbitMQConsumers\BasicConsumers;

use ErrorException;
use InvalidArgumentException;
use Monolog\Logger;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Logger\AppLogger;
use Otus\Queue\RabbitMQ\RabbitMQ;
use Otus\Message\Message;
use PhpAmqpLib\Exception\AMQPTimeoutException;

class ConsumerA extends RabbitMQ implements RabbitMQConsumer
{
    public function __construct()
    {
        parent::__construct();
        $this->channel->queue_declare($_ENV["RABBITMQ_BASIC_QUEUE"], false, true, false, false);
    }

    /**
     * @throws AMQPTimeoutException
     * @throws InvalidArgumentException
     * @throws ErrorException
     */
    public function start()
    {
        $callback = function ($msg) {
            Message::showMessage('message from queue: ' . $msg->body);
            $msg->ack();

            if ($_ENV['RABBITMQ_DEBUG_CONSUMERS']) {
                AppLogger::addLog(Logger::DEBUG, 'Processed in ' . self::class . ', data: ' . $msg->body);
            }
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($_ENV["RABBITMQ_BASIC_QUEUE"], '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}