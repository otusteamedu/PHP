<?php

declare(strict_types=1);

namespace App\Queue;

interface QueueClientInterface
{
    public function publish(
        string $data,
        string $exchangeName = '',
        string $routingKey = '',
        bool $mandatory = false,
        array $options = []
    );

    public function consume(string $queueName, array $options = []);

    public function exchangeDeclare(string $name, array $options = []);

    public function queueDeclare(string $name, array $options = []);
}
