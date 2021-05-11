<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Film\UseCase\Update\UpdateFilmCommand;
use App\Model\Film\UseCase\Update\UpdateFilmHandler;
use Exception;

class UpdateCommand implements CommandInterface
{
    private UpdateFilmHandler $updateFilmHandler;

    public function __construct(UpdateFilmHandler $updateFilmHandler)
    {
        $this->updateFilmHandler = $updateFilmHandler;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $argument = Console::getArgument(2);

        $data = $this->convertArgumentToArray($argument);

        $command = $this->convertDataToCommand($data);

        $this->updateFilmHandler->handle($command);

        Console::success('Фильм успешно изменен');
    }

    private function convertArgumentToArray(string $argument): array
    {
        $data = json_decode($argument, true);

        return (is_array($data) ? $data : []);
    }

    private function convertDataToCommand(array $data): UpdateFilmCommand
    {
        $command = new UpdateFilmCommand();

        $command->id = $data['id'] ?? '';
        $command->name = $data['name'] ?? '';
        $command->productionYear = $data['productionYear'] ?? 0;

        return $command;
    }
}