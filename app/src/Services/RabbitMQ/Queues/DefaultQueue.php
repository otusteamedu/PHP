<?php

namespace App\Services\RabbitMQ\Queues;

class DefaultQueue extends BaseQueue
{
    protected string $name = 'default';
}