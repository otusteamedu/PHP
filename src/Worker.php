<?php

namespace hw15;

use Exception;

/**
 * Class Worker
 * @package hw15
 */
class Worker extends Client
{
    const EVENT_INCREMENT = 'event.increment';
    const EVENT_CONDITION = 'event.condition';
    const EVENT_LIST_NAME = 'events';


    /**
     * @param Event $eventItem
     * @throws Exception
     */
    public function addEventToList(Event $eventItem)
    {
        $id = $this->increment(self::EVENT_INCREMENT);
        $eventItem->id = $id;
        try {
            $this->startTransaction();
            $this->setEventListItem(self::EVENT_LIST_NAME, $eventItem);
            foreach ($eventItem->getConditions() as $param => $value) {
                $this->addCondition($id, $param, $value);
            }
            $this->endTransaction();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param array $conditions
     * @return array
     * @throws Exception
     */
    public function getAllEventsByConditions(array $conditions): array
    {
        $ids = $this->getEventIdsByConditions($conditions);
        if (!$ids) {
            return [];
        }
        $eventsList = $this->getEventListsByIds($ids);
        if (!$eventsList) {
            return [];
        }

        return $eventsList;
    }

    public function sortConditionsByPriority(array $events): array
    {
        return usort($events, function (Event $a, Event $b) {
            return $a->priority - $b->priority;
        });
    }

    /**
     * @param string $conditions
     * @return array|mixed
     * @throws Exception
     */
    public function getEventByConditions(string $conditions)
    {
        $conditions = json_decode($conditions, true);

        $events = $this->getAllEventsByConditions($conditions);

        $events = $this->sortConditionsByPriority($events);

        return (count($events) > 1) ? $events[0] : $events;
    }

    /**
     * @throws Exception
     */
    public function clearData()
    {
        $this->deleteByKeyPattern(self::EVENT_LIST_NAME . ".*");
        $this->deleteByKeyPattern(self::EVENT_CONDITION . ".*");
    }
}