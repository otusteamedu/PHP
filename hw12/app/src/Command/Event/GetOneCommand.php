<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\Entity\EventId;
use App\Model\Event\Repository\EventRepositoryInterface;

class GetOneCommand implements CommandInterface
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): void
    {
        $id = Console::getArgument(2);

        $eventId = new EventId($id);

        $event = $this->eventRepository->getOne($eventId);

        Console::success('Информация о событии получена:');
        Console::success(print_r($event->toArray(), true));
    }

}