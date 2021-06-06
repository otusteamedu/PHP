<?php


namespace App\Services\RabbitMQ\Queues;


interface Queue
{
    public function getName(): string;
    public function isPassive(): bool;
    public function setPassive(bool $passive): void;
    public function isDurable(): bool;
    public function setDurable(bool $durable): void;
    public function isExclusive(): bool;
    public function setExclusive(bool $exclusive): void;
    public function isAutoDelete(): bool;
    public function setAutoDelete(bool $autoDelete): void;
    public function isNowait(): bool;
    public function setNowait(bool $nowait): void;
    public function getArguments(): array;
    public function setArguments(array $arguments): void;
    public function getTicket(): ?int;
    public function setTicket(?int $ticket): void;
}