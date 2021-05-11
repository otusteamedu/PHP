<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Film\UseCase\Update\UpdateFilmCommand;
use App\Model\Film\UseCase\Update\UpdateFilmHandler;
use App\Service\Hydrator\HydratorInterface;
use Exception;

class UpdateCommand implements CommandInterface
{
    private ConsoleInterface  $console;
    private HydratorInterface $hydrator;
    private UpdateFilmHandler $updateFilmHandler;

    public function __construct(
        ConsoleInterface $console,
        HydratorInterface $hydrator,
        UpdateFilmHandler $updateFilmHandler
    ) {
        $this->console = $console;
        $this->hydrator = $hydrator;
        $this->updateFilmHandler = $updateFilmHandler;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $data = $this->console->getArgument(2)->toArray();

        /* @var UpdateFilmCommand $command */
        $command = $this->hydrator->hydrate(UpdateFilmCommand::class, $data);

        $this->updateFilmHandler->handle($command);

        $this->console->success('Фильм успешно изменен');
    }
}