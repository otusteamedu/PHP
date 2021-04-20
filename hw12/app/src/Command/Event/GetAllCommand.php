<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\Repository\EventRepositoryInterface;

class GetAllCommand implements CommandInterface
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): void
    {
        if (!$events = $this->eventRepository->getAll()) {
            Console::info('Список событий пуст');

            return;
        }

        Console::success('Список событий получен: ');
        foreach ($events as $event) {
            Console::info(print_r($event->toArray(), true));
        }
    }

}