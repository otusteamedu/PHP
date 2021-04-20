<?php

declare(strict_types=1);

namespace App\Model\Event\UseCase\Delete;

use App\Model\Event\Entity\EventId;
use App\Model\Event\Repository\EventRepositoryInterface;

class DeleteEventHandler
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(DeleteEventCommand $command): void
    {
        $eventId = new EventId($command->id);

        $event = $this->eventRepository->getOne($eventId);

        $this->eventRepository->delete($event);
    }

}