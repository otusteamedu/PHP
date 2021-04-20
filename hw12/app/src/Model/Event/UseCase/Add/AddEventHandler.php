<?php

declare(strict_types=1);

namespace App\Model\Event\UseCase\Add;

use App\Model\Event\Entity\Condition;
use App\Model\Event\Entity\Event;
use App\Model\Event\Entity\EventId;
use App\Model\Event\Repository\EventRepositoryInterface;

class AddEventHandler
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(AddEventCommand $command): void
    {
        $event = $this->buildEvent($command);

        $this->eventRepository->add($event);
    }

    private function buildEvent(AddEventCommand $command): Event
    {
        $event = new Event(
            EventId::next(),
            $command->name,
            $command->priority
        );

        foreach ($command->conditions as $paramName => $paramValue) {
            $event->addCondition(
                new Condition(strval($paramName), strval($paramValue))
            );
        }

        return $event;
    }
}