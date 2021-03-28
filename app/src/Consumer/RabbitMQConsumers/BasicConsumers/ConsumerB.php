<?php

namespace Otus\Consumer\RabbitMQConsumers\BasicConsumers;

use Monolog\Logger;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Logger\AppLogger;
use Otus\Queue\RabbitMQ\RabbitMQ;

class ConsumerB extends RabbitMQ implements RabbitMQConsumer
{
    public function __construct()
    {
        parent::__construct();
        $this->channel->queue_declare($_ENV["RABBITMQ_BASIC_QUEUE"], false, true, false, false);
    }

    public function start()
    {
        $callback = function ($msg) {
            sleep(2);
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