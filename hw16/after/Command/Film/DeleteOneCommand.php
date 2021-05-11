<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Film\UseCase\Delete\DeleteFilmCommand;
use App\Model\Film\UseCase\Delete\DeleteFilmHandler;

class DeleteOneCommand implements CommandInterface
{
    private ConsoleInterface  $console;
    private DeleteFilmHandler $deleteFilmHandler;

    public function __construct(ConsoleInterface $console, DeleteFilmHandler $deleteFilmHandler)
    {
        $this->console = $console;
        $this->deleteFilmHandler = $deleteFilmHandler;
    }

    public function execute(): void
    {
        $filmId = $this->console->getArgument(2)->getValue();

        $command = new DeleteFilmCommand($filmId);
        $this->deleteFilmHandler->handle($command);

        $this->console->success('Фильм успешно удален');
    }
}