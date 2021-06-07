<?php

namespace App\Services\RabbitMQ\Queues;

abstract class BaseQueue implements Queue
{
    protected string $name = '';
    protected bool $passive = false;
    protected bool $durable = false;
    protected bool $exclusive = false;
    protected bool $autoDelete = true;
    protected bool $nowait = false;
    protected array $arguments = [];
    protected ?int $ticket = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPassive(): bool
    {
        return $this->passive;
    }

    /**
     * @param bool $passive
     */
    public function setPassive(bool $passive): void
    {
        $this->passive = $passive;
    }

    /**
     * @return bool
     */
    public function isDurable(): bool
    {
        return $this->durable;
    }

    /**
     * @param bool $durable
     */
    public function setDurable(bool $durable): void
    {
        $this->durable = $durable;
    }

    /**
     * @return bool
     */
    public function isExclusive(): bool
    {
        return $this->exclusive;
    }

    /**
     * @param bool $exclusive
     */
    public function setExclusive(bool $exclusive): void
    {
        $this->exclusive = $exclusive;
    }

    /**
     * @return bool
     */
    public function isAutoDelete(): bool
    {
        return $this->autoDelete;
    }

    /**
     * @param bool $autoDelete
     */
    public function setAutoDelete(bool $autoDelete): void
    {
        $this->autoDelete = $autoDelete;
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