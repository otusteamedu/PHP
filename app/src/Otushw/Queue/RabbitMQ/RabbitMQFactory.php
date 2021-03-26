<?php


namespace Otushw\Queue\RabbitMQ;

use Otushw\Queue\QueueConnectionInterface;
use Otushw\Queue\QueueConsumerInterface;
use Otushw\Queue\QueueFactory;
use Otushw\Queue\QueueProducerInterface;

class RabbitMQFactory extends QueueFactory
{
    public function createConnection(): QueueConnectionInterface
    {
        return new RabbitMQConnection();
    }

    public function createProducer(QueueConnectionInterface $queueConnection): QueueProducerInterface
    {
        return new RabbitMQProducer($queueConnection);
    }

    public function createConsumer(QueueConnectionInterface $queueConnection): QueueConsumerInterface
    {
        return new RabbitMQConsumer($queueConnection);
    }

}