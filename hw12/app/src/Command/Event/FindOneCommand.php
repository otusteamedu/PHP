<?php

declare(strict_types=1);

namespace App\Command\Event;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Event\Entity\Condition;
use App\Model\Event\Repository\EventRepositoryInterface;
use InvalidArgumentException;

class FindOneCommand implements CommandInterface
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): void
    {
        $argument = Console::getArgument(2);

        $data = $this->convertArgumentToArray($argument);
        $params = $this->extractParamsFrom($data);

        $this->throwExceptionIfParamsIsNotSpecified($params);

        $conditions = $this->convertParamsToConditions($params);

        if (!$event = $this->eventRepository->findOneByConditions($conditions)) {
            Console::info('По указанным параметрам событий не найдено');

            return;
        }

        Console::success('Событие найдено:');
        Console::success(print_r($event->toArray(), true));
    }

    private function convertArgumentToArray(string $argument): array
    {
        $data = json_decode($argument, true);

        return (is_array($data) ? $data : []);
    }

    private function extractParamsFrom(array $data): array
    {
        return (!empty($data['params'] and is_array($data['params'])) ? $data['params'] : []);
    }

    private function throwExceptionIfParamsIsNotSpecified(array $params): void
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Не указаны параметры поиска');
        }
    }

    /**
     * @param array $params
     *
     * @return Condition[]
     */
    private function convertParamsToConditions(array $params): array
    {
        $conditions = [];

        foreach ($params as $paramName => $paramValue) {
            $conditions[] = new Condition(strval($paramName), strval($paramValue));
        }

        return $conditions;
    }

}