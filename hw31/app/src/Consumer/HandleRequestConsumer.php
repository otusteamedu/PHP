<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Framework\Console\ConsoleInterface;
use App\Model\Request\UseCase\Handle\HandleRequestCommand;
use App\Model\Request\UseCase\Handle\HandleRequestHandler;
use App\Service\Queue\ConsumerInterface;
use App\Service\Queue\QueueMessage;
use Exception;

class HandleRequestConsumer implements ConsumerInterface
{
    private HandleRequestHandler $handleRequestHandler;
    private ConsoleInterface     $console;

    public function __construct(
        HandleRequestHandler $handleRequestHandler,
        ConsoleInterface $console
    ) {
        $this->handleRequestHandler = $handleRequestHandler;
        $this->console = $console;
    }

    /**
     * @throws Exception
     */
    public function consume(QueueMessage $message): void
    {
        $msg = json_decode($message->getBody(), false);

        $command = new HandleRequestCommand($msg->id);

        $this->handleRequestHandler->handle($command);

        $this->console->success('Запрос ' . $command->id . ' обработан');
    }
}