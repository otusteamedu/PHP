<?php


namespace App\Services\Events\Repositories\Redis;


use App\Services\Events\Repositories\iEventSearchRepository;
use Illuminate\Redis\Connections\Connection;

class RedisEventSearchRepository implements iEventSearchRepository
{
    private $redis;

    public function __construct(Connection $connection)
    {
        $this->redis = $connection->client();
    }

    public function getByCondition(array $conditions): ?array
    {
        $redis = $this->redis;
        $events = collect();
        foreach ($conditions as $key => $value) {
            $events->push(...$this->redis->sMembers(RedisEventRepository::EVENT_CONDITION_PREFIX . "$key:$value"));
        }
        $events = $events->unique()->map(static function ($name) use ($redis) {
            return [
                'name'       => $name,
                'conditions' => collect($redis->hGetAll(RedisEventRepository::EVENT_PREFIX . $name))
            ];
        })->filter(static function ($event) use ($conditions) {
            return $event['conditions']->diffAssoc($conditions)->isEmpty();
        })->map(static function ($event) use ($redis) {
            $event['priority'] = $redis->get(RedisEventRepository::EVENT_PRIORITY_PREFIX . $event['name']);
            $event['conditions'] = $event['conditions']->toArray();
            return $event;
        });
        return $events->sortByDesc('priority')->first();
    }
}
