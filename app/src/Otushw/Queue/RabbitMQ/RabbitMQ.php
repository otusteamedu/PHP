<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;

class RabbitMQ
{
    const EXCHANGE = 'custom_exchange';
    const QUEUE_NAME = 'custom_queue_name';
    const ROUTING_KEY = 'custom_routing_key';

    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->channel = RabbitMQConnection::getInstanceChannel();
        $this->queueDeclare();
    }

    private function queueDeclare(): void
    {
        $this->channel->queue_declare(
            self::QUEUE_NAME,
            false,
            true,
            false,
            false
        );
    }
}