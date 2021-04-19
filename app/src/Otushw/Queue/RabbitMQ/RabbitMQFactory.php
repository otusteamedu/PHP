<?php


namespace Otushw\Queue\RabbitMQ;

use Otushw\Queue\QueueConsumerInterface;
use Otushw\Queue\QueueFactory;
use Otushw\Queue\QueueProducerInterface;

class RabbitMQFactory extends QueueFactory
{

    public function createProducer(): QueueProducerInterface
    {
        return new RabbitMQProducer();
    }

    public function createConsumer(): QueueConsumerInterface
    {
        return new RabbitMQConsumer();
    }

}