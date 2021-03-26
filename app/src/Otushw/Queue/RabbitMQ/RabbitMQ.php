<?php


namespace Otushw\Queue\RabbitMQ;

use Otushw\Queue\QueueConnectionInterface;
use PhpAmqpLib\Channel\AMQPChannel;

class RabbitMQ
{
    const EXCHANGE = 'custom_exchange';
    const QUEUE_NAME = 'custom_queue_name';
    const ROUTING_KEY = 'custom_routing_key';

    protected RabbitMQConnection $queueConnection;
    protected AMQPChannel $channel;

    public function __construct()
    {
        $queueConnection = RabbitMQConnection::getInstance();

        $this->channel = $queueConnection->getChannel();
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