<?php

declare(strict_types=1);

namespace App\Model\Event\UseCase\DeleteAll;

use App\Model\Event\Repository\EventRepositoryInterface;

class DeleteAllEventHandler
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(): void
    {
        $this->eventRepository->deleteAll();
    }

}