<?php


namespace App\Services\RabbitMQ\Logger;


use PhpAmqpLib\Message\AMQPMessage;

class ConsumerMessageLogger implements MessageLogger
{
    public function log(AMQPMessage $message) : void
    {
        echo PHP_EOL.'--------'.PHP_EOL;
        echo 'Exchange: ' .  $message->getExchange() . PHP_EOL;
        echo 'Consumer: ' .  $message->getConsumerTag() . PHP_EOL;
        echo 'Body: ' .  $message->getBody();
        echo PHP_EOL.'--------'.PHP_EOL;
    }
}