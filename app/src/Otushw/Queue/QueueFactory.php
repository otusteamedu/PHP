<?php


namespace Otushw\Queue;

abstract class QueueFactory
{

//    abstract public function createConnection(): QueueConnectionInterface;

    abstract public function createProducer(): QueueProducerInterface;

    abstract public function createConsumer(): QueueConsumerInterface;
}
