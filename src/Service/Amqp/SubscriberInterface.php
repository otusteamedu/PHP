<?php declare(strict_types=1);

namespace Service\Amqp;

interface SubscriberInterface
{
    public function run(): void;
}
