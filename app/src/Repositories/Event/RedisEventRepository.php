<?php


namespace App\Repositories\Event;


use App\Entities\Event;
use App\Services\Redis\RedisClient;
use Illuminate\Support\Collection;

class RedisEventRepository implements EventRepository
{
    protected const INDEX = 'events';
    protected \Redis $redisClient;

    public function __construct()
    {
        $this->redisClient = RedisClient::get();
    }

    public function getAll(): Collection
    {
        $events = $this->getAllHashKeysFromStorage();

        $result = collect();
        foreach ($events as $id => $hashKey){
            $result->push($this->getById($id));
        }

        return $result;
    }

    public function flushAll() : int
    {
        $events = $this->getAllHashKeysFromStorage();

        foreach ($events as $id => $hashKey){
            $this->delete($id);
        }

        return $this->redisClient->hDel(self::INDEX,...array_keys($events));
    }

    public function getById(int $id): Event
    {
        $eventData = $this->getEventDataByHashKey($this->getHashKey($id));

        return $this->makeEntity($eventData);
    }

    public function delete(int $id) : int
    {
        $event = $this->getById($id);

        $this->deleteIndex($event);

        $hashKey = $this->getHashKey($id);

        return $this->redisClient->hDel(
            $hashKey,
            ...array_keys(array_dot($this->getEventDataByHashKey($hashKey)))
        );
    }

    public function getAppropriateEventsByParams(array $params, $offset = 0, $limit = 1) : Collection
    {
        $eventsHashKeys = array_intersect(
            $this->getEventHashKeysByParams($params, $offset, $limit),
            $this->getSortedEventHashKeysByPriority($offset, $limit)
        );

        return $this->getEventsByHashKeys($eventsHashKeys);
    }

    public function searchByParams(array $params, int $offset = 0, int $limit = 100): Collection
    {
        return $this->getEventsByHashKeys($this->getEventHashKeysByParams($params, $offset, $limit));
    }

    public function search(string $string, int $offset = 0, int $limit = 100): Collection
    {
        $iterator = null;
        $eventsHashKeys = $this->redisClient->hScan($this->getEventNameKey(), $iterator, "*$string*", $limit + $offset);

        return $this->getEventsByHashKeys($eventsHashKeys);
    }

    /**
     * @param Event $event
     * @return Event
     */
    public function save(Event $event): Event
    {
        if(is_null($event->getId())){
            $event->setId($this->getNextId());
        }

        $this->saveIndex($event);

        $this->redisClient->hSet(
            self::INDEX,
            $event->getId(),
            $this->getHashKey($event->getId()),
        );

        $this->redisClient->hMSet(
            $this->getHashKey($event->getId()),
            array_dot($event->toArray()),
        );

        return $event;
    }

    protected function getEventDataByHashKey(string $hashKey): array
    {
        $eventData = $this->redisClient->hGetAll($hashKey);

        $result = [];
        foreach ($eventData as $key => $value) {
            array_set($result, $key, $value);
        }

        return $result;
    }

    protected function getEventHashKeysByParams(array $params, int $offset = 0, int $limit = 100) : array
    {
        $eventHashKeysByCountParams = $this->redisClient->sort($this->getParamCountKey(count($params)), [
            'alpha' => true,
            ['limit' => [$offset, $limit]]
        ]);

        $paramsKeys = array_map(function($value, $index){
            return $this->getParamKey($index,$value);
        }, $params, array_keys($params));

        $eventHashKeysByParamValues = $this->redisClient->sInter(...$paramsKeys);

        return array_intersect(
            $eventHashKeysByCountParams,
            $eventHashKeysByParamValues
        );
    }

    protected function getSortedEventHashKeysByPriority(int $offset = 0, int $limit = 100, $sort = 'desc') : array
    {
        if($sort === 'asc'){
            return $this->redisClient->zRangeByScore(
                $this->getPriorityKey(),
                '-inf',
                '+inf',
                ['limit' => [$offset, $limit]]
            );
        }

        return  $this->redisClient->zRevRangeByScore(
            $this->getPriorityKey(),
            '+inf',
            '-inf',
            ['limit' => [$offset, $limit]]
        );
    }

    protected function getEventsByHashKeys(array $hashKeys) : Collection
    {
        $events = collect();
        foreach($hashKeys as $hashKey){
            $eventData = $this->getEventDataByHashKey($hashKey);
            $events->push($this->makeEntity($eventData));
        }

        return $events;
    }

    protected function saveIndex(Event $event) : void
    {
        foreach ($event->getParams() as $index => $value) {
            $this->redisClient->sAdd($this->getParamKey($index, $value), $this->getHashKey($event->getId()));
        }

        $this->redisClient->hSet(
            $this->getEventNameKey(),
            $event->getName(),
            $this->getHashKey($event->getId()),
        );

        $this->redisClient->sAdd($this->getParamCountKey(count($event->getParams())), $this->getHashKey($event->getId()));
        $this->redisClient->zAdd($this->getPriorityKey(), $event->getPriority(), $this->getHashKey($event->getId()));
    }

    protected function deleteIndex(Event $event) : void
    {
        foreach($event->getParams() as $index => $value){
            $this->redisClient->sRem($this->getParamKey($index, $value), $this->getHashKey($event->getId()));
        }

        $this->redisClient->hDel(
            $this->getEventNameKey(),
            $event->getName()
        );

        $this->redisClient->sRem($this->getParamCountKey(count($event->getParams())), $this->getHashKey($event->getId()));
        $this->redisClient->zRem($this->getPriorityKey(), $this->getHashKey($event->getId()));
    }

    protected function getParamKey($index, $value) : string
    {
        return self::INDEX . 'param' . $index . $value;
    }

    protected function getPriorityKey() : string
    {
        return self::INDEX . 'priority';
    }

    protected function getParamCountKey(int $count) : string
    {
        return self::INDEX . 'paramCount' . $count;
    }

    protected function getEventNameKey() : string
    {
        return self::INDEX . 'name';
    }

    protected function getHashKey(int $id) : string
    {
        return self::INDEX . ':' . $id;
    }

    protected function makeEntity(array $data) : Event
    {
        $event = new Event();
        $event->setId($data['id'] ?? 0);
        $event->setName($data['name'] ?? '');
        $event->setPriority($data['priority'] ?? 0);
        $event->setParams($data['params'] ?? []);

        return $event;
    }

    protected function getAllHashKeysFromStorage() : array
    {
        return $this->redisClient->hGetAll(self::INDEX);
    }

    protected function getNextId() : int
    {
        return count($this->getAllHashKeysFromStorage()) + 1;
    }

}