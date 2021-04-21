<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\UseCase\DeleteAll\DeleteAllEventHandler;

class DeleteAllCommand implements CommandInterface
{

    private DeleteAllEventHandler $deleteAllEventHandler;

    public function __construct(DeleteAllEventHandler $deleteAllEventHandler)
    {
        $this->deleteAllEventHandler = $deleteAllEventHandler;
    }

    public function execute(): void
    {
        $this->deleteAllEventHandler->handle();

        Console::success('Все события успешно удалены');
    }

}