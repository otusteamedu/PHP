<?php declare(strict_types=1);

namespace Service\Amqp\Producer;

class OrderCreateProducer extends AbstractProducer
{
    protected function getExchangeName(): string
    {
        return 'order.create';
    }

    protected function getQueueName(): string
    {
        return 'order.create';
    }
}
