<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQ
{
    const EXCHANGE = 'custom_exchange';
    const QUEUE_NAME = 'custom_queue_name';
    const ROUTING_KEY = 'custom_routing_key';

    protected AMQPChannel $channel;

    public function __construct()
    {
        $this->channel = RabbitMQConnection::getInstanceChannel();
        $this->exchangeDeclare();
    }

    private function exchangeDeclare(): void
    {
        $this->channel->exchange_declare(
            self::EXCHANGE,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );
    }
}