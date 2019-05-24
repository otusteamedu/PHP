<?php

namespace Otus;


use Exception;

/**
 * Class EventManager
 * @package Otus
 */
class EventManager extends Client
{

    /**
     * Add EventItem in redis
     * @param EventItem $eventItem
     */
    public function addEventToList(EventItem $eventItem)
    {

        $id = $this->increment('event.incrementer');
        $eventItem->id = $id;
        try {
            $this->startTransaction();
            $this->setEventListItem($eventItem);
            foreach ($eventItem->getConditions() as $param => $value) {
                $this->addCondition($id, $param, $value);
            }
            $this->endTransaction();
        } catch (Exception $exception) {
            echo 'Error: ' . $exception->getMessage();
            die();
        }
    }

    /**
     * Get all EventsItems by conditions
     * @param array $conditions
     * @return array
     * @throws Exception
     */
    public function getAllEventsByConditions(array $conditions): array
    {
        if (!count($conditions)) {
            throw new Exception('You need more then 0 conditions');
        }
        $ids = $this->getEventIdsByConditions($conditions);
        if (!$ids) {
            return [];
        }
        $eventsList = $this->getEventListsByIds($ids);
        if (!$eventsList) {
            return [];
        }
        usort($eventsList, function ($a, $b) {
            return -($a->priority <=> $b->priority);
        });
        return $eventsList;
    }

    /**
     * Get one EventItem ordered by priority desc by conditions
     * @param array $conditions
     * @return array|mixed
     * @throws Exception
     */
    public function getEventByConditions(array $conditions)
    {
        $events = $this->getAllEventsByConditions($conditions);
        return (count($events) > 1) ? $events[0] : $events;
    }

    /**
     * Reset all active EventsItems and EventConditions from redis
     */
    public function clearData()
    {
        $this->deleteByKeyPattern('eventList.*');
        $this->deleteByKeyPattern('event.condition.*');
    }
}