<?php


namespace App\Services\RabbitMQ\Publishers;

use App\Services\RabbitMQ\Exchanges\Exchange;

interface Publisher
{
    public function getExchange(): Exchange;
    public function getRoutingKey(): string;
    public function setRoutingKey(string $routingKey): void;
    public function isMandatory(): bool;
    public function setMandatory(bool $mandatory): void;
    public function isImmediate(): bool;
    public function setImmediate(bool $immediate): void;
    public function getTicket(): ?int;
    public function setTicket(?int $ticket): void;
}