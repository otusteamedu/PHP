<?php


namespace App\Services\Event\Repositories\Redis;


use App\Models\Event;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Traits\HasEventSearch;
use Illuminate\Contracts\Redis\Connection;
use Illuminate\Support\Collection;

/**
 * Class RedisSearchEventRepository
 * @package App\Services\Event\Repositories\Redis
 */
class RedisSearchEventRepository implements ISearchEventRepository
{
    use HasEventSearch;

    private \Redis $redis;

    /**
     * RedisEventRepositoryII constructor.
     */
    public function __construct(Connection $redisConnection)
    {
        $this->redis = $redisConnection->client();
    }

    public function getEvents(): Collection
    {
        $eventsList = $this->redis->sMembers(RedisWriteEventRepository::EVENT_LIST_PREFIX);
        return  $this
            ->buildCollection($eventsList)
            ->sortByDesc('priority');
    }

    public function searchEvents(array $conditions): Collection
    {
        $selectedEvents = $this->selectEventsByConditions($conditions);
        return $this
            ->buildCollection($selectedEvents)
            ->sortByDesc('priority');
    }

    public function getEventByCondition(array $conditions): ?Event
    {
        return $this->searchEvents($conditions)->first();
    }

    /**
     * Возвращает из хранилища Redis приоритет для события с именем $eventName
     *
     * @param $eventName
     * @return int
     */
    private function getEventsPriority($eventName): int
    {
        return $this->redis->get(RedisWriteEventRepository::EVENT_PRIORITY_PREFIX.$eventName);
    }

    /**
     * Возвращает из хранилища Redis набор условий в виде массива для события с именем $eventName
     *
     * @param $eventName
     * @return array
     */
    private function getEventsConditions($eventName): array
    {
        $params =  $this->redis->hKeys(RedisWriteEventRepository::EVENT_PREFIX.$eventName);
        $values = $this->redis->hMGet(RedisWriteEventRepository::EVENT_PREFIX.$eventName, $params);
        return array_combine($params, $values);
    }

    /**
     * Возвращает коллекцию событий на основе $eventsList
     *
     * @param array $eventsList
     * @return Collection
     */
    private function buildCollection(array $eventsList): Collection
    {
        $events = new Collection();
        foreach ($eventsList as $event) {
            $events->add(new Event(
                [
                    'name' => $event,
                    'priority' => $this->getEventsPriority($event),
                    'conditions' => $this->getEventsConditions($event)
                ]
            ));
        }
        return $events;
    }

    /**
     * Возвращает набор событий, подходящих по условию передаваемому в $conditions
     *
     * @param array $conditions
     * @return array
     */
    private function selectEventsByConditions(array $conditions): array
    {
        // создаем общий список событий, в которых содержится хотя бы одно из условий из $conditions
        $eventsList = [];
        foreach ($conditions as $param => $value) {
            $searchingKey = RedisWriteEventRepository::EVENT_CONDITION_PREFIX.$param.":".$value;
            $eventsList = array_unique(
                array_merge($eventsList, $this->redis->sMembers($searchingKey))
            );
        }
        // формируем список событий с полным набором условий для каждого события
        $EventListWithConditions = [];
        foreach ($eventsList as $event) {
            $EventListWithConditions[$event] = $this->getEventsConditions($event);
        }
        return $this->getItemsSatisfiesConditions($EventListWithConditions, $conditions);
    }
}
