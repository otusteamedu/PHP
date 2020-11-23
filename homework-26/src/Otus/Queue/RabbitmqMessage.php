<?php

namespace Otus\Queue;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqMessage implements MessageContract
{
    private AMQPMessage $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    public function getData(): string
    {
        return $this->message->getBody();
    }
}