<?php


namespace App\Services\Events\Repositories\Redis;


use App\Services\Events\Repositories\iEventRepository;
use Illuminate\Redis\Connections\Connection;

class RedisEventRepository implements iEventRepository
{

    public const EVENT_PREFIX = 'events:';
    public const EVENT_CONDITION_PREFIX = "events:param:";
    public const EVENT_PRIORITY_PREFIX = "events:priority:";

    private $redis;

    public function __construct(Connection $connection)
    {
        $this->redis = $connection->client();
    }

    /**
     * @param $data
     * @return void
     */
    public function add($data): void
    {
        $this->redis->hMSet(self::EVENT_PREFIX . $data['name'], $data['conditions']);
        $this->redis->set(self::EVENT_PRIORITY_PREFIX . $data['name'], $data['priority']);
        foreach ($data['conditions'] as $key => $value) {
            $this->redis->sAdd(self::EVENT_CONDITION_PREFIX . "$key:$value", $data['name']);
        }
    }

    /**
     * @param string $name
     */
    public function delete(string $name): void
    {
        $conditions = $this->redis->hGetAll(self::EVENT_PREFIX . $name);
        foreach ($conditions as $key => $value) {
            $this->redis->sRem(self::EVENT_CONDITION_PREFIX . "$key:$value", $name);
        }
        $this->redis->hDel(self::EVENT_PREFIX . $name, ...array_keys($conditions));
        $this->redis->del(self::EVENT_PRIORITY_PREFIX . $name);
    }

    public function clear(): void
    {
        $it = null;
        $this->redis->del(collect(
            $this->redis->scan(
                $it,
                config('database.redis.options.prefix') . 'events:*'))
            ->map(function ($key) {
                return preg_replace('/^' . config('database.redis.options.prefix') . '/', '', $key);
            })->toArray());
    }

}
