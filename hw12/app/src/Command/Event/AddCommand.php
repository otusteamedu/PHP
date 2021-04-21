<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\UseCase\Add\AddEventCommand;
use App\Model\Event\UseCase\Add\AddEventHandler;

class AddCommand implements CommandInterface
{

    private AddEventHandler $deleteEventHandler;

    public function __construct(AddEventHandler $deleteEventHandler)
    {
        $this->deleteEventHandler = $deleteEventHandler;
    }

    public function execute(): void
    {
        $argument = Console::getArgument(2);

        $data = $this->convertArgumentToArray($argument);
        $command = $this->convertDataToCommand($data);

        $this->deleteEventHandler->handle($command);

        Console::success('Событие успешно добавлено');
    }

    private function convertArgumentToArray(string $argument): array
    {
        $data = json_decode($argument, true);

        return (is_array($data) ? $data : []);
    }

    private function convertDataToCommand(array $data): AddEventCommand
    {
        $command = new AddEventCommand();

        $command->name = $data['name'] ?? '';
        $command->priority = $data['priority'] ?? 0;
        $command->conditions = $data['conditions'] ?? [];

        return $command;
    }

}