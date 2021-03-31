<?php


namespace Otus\Consumer\RabbitMQConsumers\BasicConsumers;


use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;

class ConsumerFactory
{
    public static function createConsumer(): RabbitMQConsumer
    {
        return new ConsumerA();
    }
}