<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Film\UseCase\Delete\DeleteFilmCommand;
use App\Model\Film\UseCase\Delete\DeleteFilmHandler;

class DeleteOneCommand implements CommandInterface
{
    private DeleteFilmHandler $deleteFilmHandler;

    public function __construct(DeleteFilmHandler $deleteFilmHandler)
    {
        $this->deleteFilmHandler = $deleteFilmHandler;
    }

    public function execute(): void
    {
        $filmId = Console::getArgument(2);

        $command = new DeleteFilmCommand($filmId);
        $this->deleteFilmHandler->handle($command);

        Console::success('Фильм успешно удален');
    }
}