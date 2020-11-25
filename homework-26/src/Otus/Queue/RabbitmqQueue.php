<?php

namespace Otus\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqQueue implements QueueContract
{
    private AMQPChannel $channel;

    public function __construct(AbstractConnection $connection)
    {
        $this->channel = $connection->channel();
    }

    public function push(string $queue, $data): void
    {
        $message = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($message, '', $queue);
    }

    public function pop(string $queue): MessageContract
    {
        $message = $this->channel->basic_get($queue);

        if (! $message instanceof AMQPMessage) {
            return new RabbitmqMessage(
                new AMQPMessage()
            );
        }

        $this->channel->basic_ack($message->getDeliveryTag());

        return new RabbitmqMessage($message);
    }
}
