<?php

namespace App\Services\RabbitMQ\Consumers;
use App\Services\RabbitMQ\Logger\Loggerable;
use App\Services\RabbitMQ\Logger\MessageLogger;
use App\Services\RabbitMQ\Queues\Queue;
use PhpAmqpLib\Message\AMQPMessage;

abstract class BaseConsumer implements Consumer, Loggerable
{
    protected Queue $queue;
    protected string $name = '';
    protected bool $noLocal = false;
    protected bool $noAck = false;
    protected bool $exclusive = false;
    protected bool $nowait = false;
    protected ?int $ticket = null;
    protected array $arguments = [];
    protected ?MessageLogger $logger = null;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @return Queue
     */
    public function getQueue(): Queue
    {
        return $this->queue;
    }

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
    public function isNoLocal(): bool
    {
        return $this->noLocal;
    }

    /**
     * @param bool $noLocal
     */
    public function setNoLocal(bool $noLocal): void
    {
        $this->noLocal = $noLocal;
    }

    /**
     * @return bool
     */
    public function isNoAck(): bool
    {
        return $this->noAck;
    }

    /**
     * @param bool $noAck
     */
    public function setNoAck(bool $noAck): void
    {
        $this->noAck = $noAck;
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
     * @return MessageLogger
     */
    public function getLogger() : MessageLogger
    {
        return $this->logger;
    }

    /**
     * @param MessageLogger $logger
     */
    public function setLogger(MessageLogger $logger): void
    {
        $this->logger = $logger;
    }

    public function handle(AMQPMessage $message): void
    {
       if(is_null($this->logger)){
           return;
       }

       $this->logger->log($message);
    }
}