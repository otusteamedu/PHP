<?php

declare(strict_types=1);

namespace App\Service\Queue;

interface QueueClientInterface
{
    public function connect(): void;

    public function publish(string $queueName, $message): void;

    public function subscribe(string $queueName, ConsumerInterface $consumer): void;

    public function wait(string $queueName): void;

    public function disconnect(): void;
}