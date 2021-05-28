<?php

namespace App\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterface
{
    public function __invoke(AMQPMessage $message): void;
}
