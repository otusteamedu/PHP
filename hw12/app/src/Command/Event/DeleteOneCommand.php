<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\UseCase\Delete\DeleteEventCommand;
use App\Model\Event\UseCase\Delete\DeleteEventHandler;

class DeleteOneCommand implements CommandInterface
{

    private DeleteEventHandler $deleteEventHandler;

    public function __construct(DeleteEventHandler $deleteEventHandler)
    {
        $this->deleteEventHandler = $deleteEventHandler;
    }

    public function execute(): void
    {
        $eventId = Console::getArgument(2);

        $command = new DeleteEventCommand($eventId);
        $this->deleteEventHandler->handle($command);

        Console::success('Событие успешно удалено');
    }

}