<?php


namespace App\Repositories\Event;


use App\Entities\Event;
use App\Services\Redis\RedisClient;
use Illuminate\Support\Collection;
use JsonException;

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
        $events = $this->getAllFromStorage();

        $result = collect();
        foreach ($events as $eventData){
            $result->push($this->makeEntity(json_decode($eventData, true)));
        }

        return $result;
    }

    public function flushAll() : int
    {
        return $this->redisClient->hDel(self::INDEX,...array_keys($this->getAllFromStorage()));
    }

    public function getById(string $id): Event
    {
        // TODO: Implement getById() method.
    }

    public function search(string $string, int $offset = 0, int $limit = 100): Collection
    {
        // TODO: Implement search() method.
    }

    /**
     * @param Event $event
     * @return Event
     * @throws JsonException
     */
    public function save(Event $event): Event
    {
        if(is_null($event->getId())){
            $event->setId($this->getNextId());
        }

        $this->redisClient->hSet(
            self::INDEX,
            $event->getId(),
            json_encode($event->toArray(), JSON_THROW_ON_ERROR)
        );

        return $event;
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

    protected function getAllFromStorage() : array
    {
        return $this->redisClient->hGetAll(self::INDEX);
    }

    protected function getNextId() : int
    {
        return count($this->getAllFromStorage()) + 1;
    }

}