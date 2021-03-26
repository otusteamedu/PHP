<?php


namespace Otushw\Queue\RabbitMQ;

use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Otushw\Queue\QueueProducerInterface;

class RabbitMQProducer extends RabbitMQ implements QueueProducerInterface
{

    public function publish(string $data): void
    {
        $this->channel->exchange_declare(
            self::EXCHANGE,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );

        $this->channel->queue_bind(
            self::QUEUE_NAME,
            self::EXCHANGE,
            self::ROUTING_KEY
        );

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
