<?php

namespace App\MessageHandler;

use PhpAmqpLib\Message\AMQPMessage;

class ConsoleMessageHandler implements MessageHandlerInterface
{

    public function __invoke(AMQPMessage $message): void
    {
        echo ' [x] Получено "', $message->body, '"', PHP_EOL;
        echo ' [x] Идет обработка...', PHP_EOL;

        sleep(rand(5, 15));

        echo ' [x] Готово', PHP_EOL;
        $message->ack();
    }
}
