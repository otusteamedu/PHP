<?php


namespace App\Services\RabbitMQ\Logger;


use PhpAmqpLib\Message\AMQPMessage;

interface MessageLogger
{
    public function log(AMQPMessage $message);
}