<?php


namespace App\Services\RabbitMQ\Publishers;
use App\Services\RabbitMQ\Exchanges\Exchange;

abstract class BasePublisher implements Publisher
{
    protected Exchange $exchange;
    protected string $routingKey = '';
    protected bool $mandatory = false;
    protected bool $immediate = false;
    protected ?int $ticket = null;

    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
    }

    /**
     * @return Exchange
     */
    public function getExchange(): Exchange
    {
        return $this->exchange;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @param string $routingKey
     */
    public function setRoutingKey(string $routingKey): void
    {
        $this->routingKey = $routingKey;
    }

    /**
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    /**
     * @param bool $mandatory
     */
    public function setMandatory(bool $mandatory): void
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @return bool
     */
    public function isImmediate(): bool
    {
        return $this->immediate;
    }

    /**
     * @param bool $immediate
     */
    public function setImmediate(bool $immediate): void
    {
        $this->immediate = $immediate;
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