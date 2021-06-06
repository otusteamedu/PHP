<?php

namespace App\Services\RabbitMQ\DTO;

final class SourceBindDto
{
    private string $routingKey;
    private bool $nowait = false;
    private array $arguments = [];
    private ?int $ticket = null;

    public function __construct(string $routingKey = '')
    {
        $this->routingKey = $routingKey;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @return bool
     */
    public function isNowait(): bool
    {
        return $this->nowait;
    }

    /**
     * @param bool $nowait
     */
    public function setNowait(bool $nowait): void
    {
        $this->nowait = $nowait;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return int|null
     */
    public function getTicket(): ?int
    {
        return $this->ticket;
    }

    /**
     * @param int|null $ticket
     */
    public function setTicket(?int $ticket): void
    {
        $this->ticket = $ticket;
    }
}