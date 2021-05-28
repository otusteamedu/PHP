<?php

namespace App\Services;

use App\Models\Event;
use App\Models\BaseModel;
use App\Repositories\CUDRepositoryInterface;
use App\Exceptions\NoConditionsOrNameInEvent;
use App\ModelHydrators\RedisHydratorInterface;
use App\ModelHydrators\RequestHydratorInterface;

class RedisEventService
{
    private const PIVOT_KEY_PREFIX = 'params';
    /**
     * @var CUDRepositoryInterface
     */
    private CUDRepositoryInterface $eventRepository;

    /**
     * @var RequestHydratorInterface
     */
    private RequestHydratorInterface $requestModelHydrator;

    /**
     * @var RedisHydratorInterface
     */
    private RedisHydratorInterface $redisModelHydrator;

    /**
     * RedisEventService constructor.
     *
     * @param CUDRepositoryInterface $eventRepository
     * @param RequestHydratorInterface $requestModelHydrator
     * @param RedisHydratorInterface $redisModelHydrator
     */
    public function __construct(CUDRepositoryInterface $eventRepository, RequestHydratorInterface $requestModelHydrator, RedisHydratorInterface $redisModelHydrator)
    {
        $this->eventRepository = $eventRepository;
        $this->requestModelHydrator = $requestModelHydrator;
        $this->redisModelHydrator = $redisModelHydrator;
    }

    /**
     * @return Event[]
     */
    public function getAllEvents(): array
    {
        $rawEvents = $this->eventRepository->getAll();

        $events = [];
        foreach ($rawEvents as $event) {
            $model = unserialize($event);
            $events[] = $model->toArray();
        }

        return $events;
    }

    /**
     * @param array $rawData
     * @return mixed
     */
    public function addEvent(array $rawData): mixed
    {
        $event = $this->saveEventToRedis($rawData);

        $this->saveIndexData($event, $rawData);

        return $event;
    }

    /**
     * @param array $rawData
     * @return mixed
     */
    public function saveEventToRedis(array $rawData): mixed
    {
        $eventModels = $this->requestModelHydrator->hydrate($rawData);
        $eventModel = array_pop($eventModels);

        $this->eventRepository->insert($eventModel);

        return $eventModel;
    }

    /**
     * @param BaseModel $event
     * @param array $rawData
     */
    public function saveIndexData(BaseModel $event, array $rawData)
    {
        if (!($rawData['conditions'] ?? null) && !$event->getName())
            throw new NoConditionsOrNameInEvent();

        //this method creates data in redis like sadd "params:param1_condition1_param2_condition2 eventNames"
        //where eventName is a name of event that support all specified conditions
        $this->eventRepository->saveConditionsEventIndex($rawData['conditions'], $event->getName());
    }

    /**
     * @return bool
     */
    public function flushAllEvents(): bool
    {
        $this->eventRepository->flushDataByPattern(Event::getPrefixStatic() . '*');
        $this->eventRepository->flushDataByPattern(self::PIVOT_KEY_PREFIX . ':*');

        return true;
    }

    /**
     * @param array $searchData
     *
     * @return Event
     */
    public function searchEventsByParams(array $searchData)
    {
        $eventKeys = $this->eventRepository->searchEventKeyByParamsInIndex($searchData['params']);
        $serializedEvents = $this->eventRepository->getEventByKeys($eventKeys);
        $events = $this->redisModelHydrator->hydrate($serializedEvents);

        return $this->getEventWithHighestPriority($events);
    }

    /**
     * @param Event[] $events
     *
     * @return Event
     */
    public function getEventWithHighestPriority(array $events): Event
    {
        return array_reduce($events, function ($carry, $value) {
            if($value && $carry && $carry->getPriority() > $value->getPriority()) {
                return $carry;
            }

            return $value;
        });
    }
}
