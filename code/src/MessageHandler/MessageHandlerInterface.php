<?php

namespace App\MessageHandler;

use PhpAmqpLib\Message\AMQPMessage;

interface MessageHandlerInterface
{
    public function __invoke(AMQPMessage $message): void;
}
