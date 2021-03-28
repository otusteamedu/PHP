<?php

namespace Otus\Queue\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;

class BasicRabbitQueue extends RabbitMQ
{
    public function addToQueue(string $data)
    {
        $this->channel->queue_declare($_ENV["RABBITMQ_BASIC_QUEUE"], false, true, false, false);

        $msg = new AMQPMessage(
            $data,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $this->channel->basic_publish($msg, '', $_ENV["RABBITMQ_BASIC_QUEUE"]);
    }
}