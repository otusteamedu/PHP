<?php


namespace App\Services\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use App\Services\RabbitMQ\Publishers\Publisher;

class EventDispatcher
{
    private array $publishers = [];
    private Manager $client;

    public function __construct(Manager $client)
    {
        $this->client = $client;
    }

    public function pushPublisher(Publisher $publisher)
    {
        $this->publishers[get_class($publisher)] = $publisher;
    }

    public function dispatch(string $publisherClass, AMQPMessage $message) : void
    {
        if(!isset($this->publishers[$publisherClass])){
            throw new \RuntimeException('Publisher ' . $publisherClass . ' not found');
        }

        $this->client->publishMessage($message, $this->publishers[$publisherClass]);
    }
}