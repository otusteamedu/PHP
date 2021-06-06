<?php


namespace App\Services\RabbitMQ;


use App\Services\RabbitMQ\DTO\SourceBindDto;
use PhpAmqpLib\Message\AMQPMessage;
use App\Services\RabbitMQ\Exchanges\Exchange;
use App\Services\RabbitMQ\Queues\Queue;
use App\Services\RabbitMQ\Consumers\Consumer;
use App\Services\RabbitMQ\Publishers\Publisher;

class Manager
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient() : Client
    {
        return $this->client;
    }

    /**
     * @param Exchange $exchange
     * @return mixed|null
     */
    public function declareExchange(Exchange $exchange)
    {
        return $this->client->getChannel()->exchange_declare(
            $exchange->getName(),
            $exchange->getType(),
            $exchange->isPassive(),
            $exchange->isDurable(),
            $exchange->isAutoDelete(),
            $exchange->isInternal(),
            $exchange->isNowait(),
            $exchange->getArguments(),
            $exchange->getTicket()
        );
    }

    public function declareQueue(Queue $queue) : ?array
    {
        return $this->client->getChannel()->queue_declare(
            $queue->getName(),
            $queue->isPassive(),
            $queue->isDurable(),
            $queue->isExclusive(),
            $queue->isAutoDelete(),
            $queue->isNowait(),
            $queue->getArguments(),
            $queue->getTicket()
        );
    }

    public function initConsumer(Consumer $consumer): string
    {
        return $this->client->getChannel()->basic_consume(
            $consumer->getQueue()->getName(),
            $consumer->getName(),
            $consumer->isNoLocal(),
            $consumer->isNoAck(),
            $consumer->isExclusive(),
            $consumer->isNowait(),
            [$consumer, 'handle'],
            $consumer->getTicket(),
            $consumer->getArguments()
        );
    }

    public function bindQueue(Queue $queue,  Exchange $exchange, SourceBindDto $sourceBindDto)
    {
        return $this->client->getChannel()->queue_bind(
            $queue->getName(),
            $exchange->getName(),
            $sourceBindDto->getRoutingKey(),
            $sourceBindDto->isNowait(),
            $sourceBindDto->getArguments(),
            $sourceBindDto->getTicket()
        );
    }

    public function publishMessage(AMQPMessage $message, Publisher $publisher) : void
    {
        $this->client->getChannel()->basic_publish(
            $message,
            $publisher->getExchange()->getName(),
            $publisher->getRoutingKey(),
            $publisher->isMandatory(),
            $publisher->isImmediate(),
            $publisher->getTicket()
        );
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function listen(): void
    {
        while ($this->client->getChannel()->is_consuming()) {
            $this->client->getChannel()->wait();
        }

        $this->client->getChannel()->close();
        $this->client->getConnection()->close();
    }
}