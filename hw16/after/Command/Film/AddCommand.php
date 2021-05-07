<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Film\UseCase\Add\AddFilmCommand;
use App\Model\Film\UseCase\Add\AddFilmHandler;
use App\Service\Hydrator\HydratorInterface;

class AddCommand implements CommandInterface
{
    private ConsoleInterface  $console;
    private HydratorInterface $hydrator;
    private AddFilmHandler    $addFilmHandler;

    public function __construct(ConsoleInterface $console, HydratorInterface $hydrator, AddFilmHandler $addFilmHandler)
    {
        $this->console = $console;
        $this->hydrator = $hydrator;
        $this->addFilmHandler = $addFilmHandler;
    }

    public function execute(): void
    {
        $data = $this->console->getArgument(2)->toArray();

        /* @var AddFilmCommand $command */
        $command = $this->hydrator->hydrate(AddFilmCommand::class, $data);

        $this->addFilmHandler->handle($command);

        $this->console->success('Фильм успешно добавлен');
    }
}