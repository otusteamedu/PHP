<?php

declare(strict_types=1);

namespace App\Queue\NewSuperMQ;

use App\Queue\QueueClientInterface;

class Client implements QueueClientInterface
{
    /**
     * @param array $data
     * @param string $exchangeName
     * @param string $routingKey
     * @param array $messageParams
     */
    public function publish(
        string $data,
        string $exchangeName = '',
        string $routingKey = '',
        array $messageParams = []
    ) {
        // TODO: Implement consume() method.
    }

    public function consume(string $queueName, array $options = [])
    {
        // TODO: Implement consume() method.
    }

    public function exchangeDeclare(string $exchangeName, array $options = [])
    {
        // TODO: Implement consume() method.
    }

    public function queueDeclare(string $name, array $options = [])
    {
        // TODO: Implement consume() method.
    }
}
