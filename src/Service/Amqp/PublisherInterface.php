<?php declare(strict_types=1);

namespace Service\Amqp;

interface PublisherInterface
{
    public function publish(string $message): void;
}
