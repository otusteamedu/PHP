<?php

namespace Classes\Queue\Brokers;

use Classes\Dto\BrokerDto;
use Classes\Queue\BrockerInterface;
use Classes\JsonHandler;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitBroker implements BrockerInterface
{
    public AMQPStreamConnection $connection;
    public AMQPChannel $channel;

    /** @var BrokerDto $brokerDto */
    private $brokerDto;

    public function __construct(BrokerDto $brokerDto)
    {
        $this->brokerDto = $brokerDto;

        $this->connection = new AMQPStreamConnection(
            $brokerDto->host,
            $brokerDto->port,
            $brokerDto->userName,
            $brokerDto->password
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($brokerDto->queueRequestName, false, false, false, false);
        $this->channel->queue_declare($brokerDto->queueResponseName, false, false, false, false);
    }


    public function pushRequest(string $request)
    {
        $this->pushQueue($this->brokerDto->queueRequestName, $request);
    }

    public function pushResponse(string $response)
    {
        $this->pushQueue($this->brokerDto->queueResponseName, $response);
    }

    public function popRequest(): string
    {
        /** @var AMQPMessage $message */
        $message = $this->readQueue($this->brokerDto->queueRequestName);

        if (!$message) {
            return null;
        }
        $requestItem = $message;
        $this->deleteMessage($message);
        return $requestItem->body;
    }

    private function readQueue($queueName)
    {
        return $this->channel->basic_get($queueName);
    }

    private function pushQueue(string $queueName, string $data)
    {
        $message = new AMQPMessage($data);
        $this->channel->basic_publish($message, '', $queueName);
    }

    public function popResponse($requestId)
    {
        /** @var AMQPMessage $message */
        $message = $this->readQueue($this->brokerDto->queueResponseName);
        if (!$message) {
            return null;
        }

        $body = json_decode($message->getBody(), true, 512, JSON_THROW_ON_ERROR);

        if ($body['id'] !== $requestId) {
            return null;
        }

        return $body['status'];
    }

    private function deleteMessage($message)
    {
        $this->channel->basic_ack($message->getDeliveryTag());
    }
}
