<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\Repository\EventRepositoryInterface;
use InvalidArgumentException;

class GetCommand implements CommandInterface
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): void
    {
        $limit = intval(Console::getArgument(2));
        $skip = intval(Console::getArgument(3));

        $this->throwExceptionIfLimitIsNotSpecified($limit);

        if (!$events = $this->eventRepository->get($limit, $skip)) {
            Console::info('Список событий пуст');

            return;
        }

        Console::success('Список событий получен: ');
        foreach ($events as $event) {
            Console::info(print_r($event->toArray(), true));
        }
    }

    private function throwExceptionIfLimitIsNotSpecified(int $limit): void
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Не указаны параметры limit');
        }
    }

}