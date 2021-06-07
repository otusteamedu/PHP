<?php

namespace App\Services\RabbitMQ\Consumers;

use PhpAmqpLib\Message\AMQPMessage;
use App\Services\RabbitMQ\Queues\Queue;

interface Consumer
{
    public function getQueue(): Queue;
    public function getName(): string;
    public function isNoLocal(): bool;
    public function setNoLocal(bool $noLocal): void;
    public function isNoAck(): bool;
    public function setNoAck(bool $noAck): void;
    public function isExclusive(): bool;
    public function setExclusive(bool $exclusive): void;
    public function isNowait(): bool;
    public function setNowait(bool $nowait): void;
    public function getTicket(): ?int;
    public function setTicket(?int $ticket): void;
    public function getArguments(): array;
    public function setArguments(array $arguments): void;
    public function handle(AMQPMessage $message) : void;
}