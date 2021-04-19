<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use Otushw\Queue\QueueProducerInterface;

class RabbitMQProducer extends RabbitMQ implements QueueProducerInterface
{

    public function publish(string $data): void
    {
        $msg = new AMQPMessage(
            $data,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $this->channel->basic_publish(
            $msg,
            self::EXCHANGE,
            self::ROUTING_KEY
        );
    }

}
