<?php


namespace Otushw\Queue;

abstract class QueueFactory
{

    abstract public function createConnection(): QueueConnectionInterface;

    abstract public function createProducer(
        QueueConnectionInterface $queueConnection,
        string $params
    ): QueueProducerInterface;

    abstract public function createConsumer(QueueConnectionInterface $queueConnection): QueueConsumerInterface;
}
