<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Film\UseCase\Add\AddFilmCommand;
use App\Model\Film\UseCase\Add\AddFilmHandler;

class AddCommand implements CommandInterface
{
    private AddFilmHandler $addFilmHandler;

    public function __construct(AddFilmHandler $addFilmHandler)
    {
        $this->addFilmHandler = $addFilmHandler;
    }

    public function execute(): void
    {
        $argument = Console::getArgument(2);

        $data = $this->convertArgumentToArray($argument);
        $command = $this->convertDataToCommand($data);

        $this->addFilmHandler->handle($command);

        Console::success('Фильм успешно добавлен');
    }

    private function convertArgumentToArray(string $argument): array
    {
        $data = json_decode($argument, true);

        return (is_array($data) ? $data : []);
    }

    private function convertDataToCommand(array $data): AddFilmCommand
    {
        $command = new AddFilmCommand();

        $command->name = $data['name'] ?? '';
        $command->productionYear = $data['productionYear'] ?? 0;

        return $command;
    }
}