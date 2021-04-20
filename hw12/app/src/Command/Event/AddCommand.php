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
        $json = Console::getArgument(2);

        $command = $this->convertJsonToCommand($json);

        $this->deleteEventHandler->handle($command);

        Console::success('Событие успешно добавлено');
    }

    private function convertJsonToCommand(string $json): AddEventCommand
    {
        $data = json_decode($json, true);
        $data = (is_array($data) ? $data : []);


        $command = new AddEventCommand();

        $command->name = $data['name'] ?? '';
        $command->priority = $data['priority'] ?? 0;
        $command->conditions = $data['conditions'] ?? [];

        return $command;
    }

}