<?php


namespace Services;


use Classes\Dto\EventDto;
use Classes\Models\Event;
use Classes\Repositories\EventRepositoryInterface;

class EventServiceImpl implements EventServiceInterface
{

    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }
    public function create(EventDto $eventDto)
    {
        $eventModel = new Event();
        $eventModel->eventName = $eventDto->eventName;
        $eventModel->eventPriority = $eventDto->eventPriority;
        $eventModel->eventCriterions = $eventDto->eventCriterions;
        return $this->eventRepository->create($eventModel);
    }

    public function deleteAll()
    {
        return $this->eventRepository->deleteAll();
    }

    public function getPriority(EventDto $eventDto)
    {
        $eventNames = $this->eventRepository->getAllKeys();
        $relevantEvents = $this->getRelevantEvents($eventNames, $eventDto);
        $sortedRelevantEvents = $this->getSortedEventsByPriority($relevantEvents);
        return array_shift($sortedRelevantEvents);
    }

    private function getEventCriterions(array $eventData): array
    {
        if (!isset($eventData['criterions'])) {
            return [];
        }
        return json_decode($eventData['criterions'], true, 512, JSON_THROW_ON_ERROR);
    }

    private function getRelevantEvents(array $eventNames, EventDto $eventDto)
    {
       $result = [];
       foreach ($eventNames as $key => $eventName) {
           $eventData = $this->eventRepository->getKeyData($eventName);
           $eventCriterions = $this->getEventCriterions($eventData);

           if (count($eventCriterions) > $eventDto->eventCriterions) {
               continue;
           }

           $diff = array_diff($eventDto->eventCriterions, $eventCriterions);

           if (count($diff) === count($eventDto->eventCriterions) ) {
               continue;
           }

           $result[] = $eventData;
       }
       return $result;
    }

    private function getSortedEventsByPriority (array $events)
    {
        uasort($events, static function ($first, $second) {
            if ($first['priority'] === $second['priority']) {
                return 0;
            }
            return ($first['priority'] < $second['priority']) ? 1 : -1;
        });

        return $events;
    }

}
