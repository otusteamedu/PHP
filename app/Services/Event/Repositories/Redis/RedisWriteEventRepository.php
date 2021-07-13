<?php


namespace App\Services\Event\Repositories\Redis;


use App\Services\Event\Repositories\IWriteEventRepository;
use Illuminate\Contracts\Redis\Connection;

/**
 * Class RedisWriteEventRepository
 * @package App\Services\Event\Repositories\Redis
 */
class RedisWriteEventRepository implements IWriteEventRepository
{
    public const EVENT_PREFIX = 'events:';
    public const EVENT_CONDITION_PREFIX = "events:conditions:";
    public const EVENT_PRIORITY_PREFIX = "events:priority:";
    public const EVENT_LIST_PREFIX = "events:list";

    private \Redis $redis;

    private string $redisPrefix;
    private int $redisDatabaseNumber;

    /**
     * RedisEventRepositoryII constructor.
     */
    public function __construct(Connection $redisConnection)
    {
        $this->redis = $redisConnection->client();
        $this->redisDatabaseNumber = config('database.redis.default.database');
        $this->redisPrefix = config('database.redis.options.prefix');
    }

    /**
     * Событие сохраняется следующим образом
     * в ключ self::EVENT_PREFIX.ИмяСобытия - сохраняются элементы условия 'conditions' с типом хеш
     * param1=Значение1, param2=Значение2, ... paramN=ЗначениеX
     * в ключ self::EVENT_PRIORITY_PREFIX.ИмяСобытия - сохраняются значения приоритетов
     * в ключ self::EVENT_CONDITION_PREFIX.paramN:ЗначениеX - сохраняются имена событий
     * в ключ self::EVENT_LIST_PREFIX будут сохраняться все имена событий
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $this->redis->sAdd(self::EVENT_LIST_PREFIX, $data['name']);
        $this->redis->hMSet(self::EVENT_PREFIX . $data['name'], $data['conditions']);
        foreach ($data['conditions'] as $param => $value) {
            $this->redis->sAdd(self::EVENT_CONDITION_PREFIX . "$param:$value", $data['name']);
        }
        return (int)$this->redis->set(self::EVENT_PRIORITY_PREFIX . $data['name'], $data['priority']);;
    }

    public function delete(string $name): bool
    {
        $conditions = $this->redis->hGetAll(self::EVENT_PREFIX.$name);
        if (empty($conditions)) {
            throw new \Exception("Event doesnt present", 0);
        }
        $this->redis->hDel(self::EVENT_PREFIX . $name, ...array_keys($conditions));
        $this->redis->sRem(self::EVENT_LIST_PREFIX, "$name");
        foreach ($conditions as $param => $value) {
            $this->redis->sRem(self::EVENT_CONDITION_PREFIX."$param:$value", $name);
        }
        return (bool)$this->redis->del(self::EVENT_PRIORITY_PREFIX . $name);
    }

    public function deleteAll(): void
    {
        $iterator = null;
        $allEventsKeys = $this->redis->scan(
            $iterator,
            $this->redisPrefix . self::EVENT_PREFIX . '*',
            $this->getCountKeys()
        );
        $toDeleteKeys = collect($allEventsKeys)->map(function ($key) {
            return preg_replace('/^' . $this->redisPrefix . '/', '', $key);
        })->toArray();
        $this->redis->del($toDeleteKeys);
    }

    /**
     * Возвращает общее количество ключей из базы с номером, указанным в конфигурации
     *
     * @return string
     */
    private function getCountKeys(): string
    {
        $infoDb = $this->redis->info("Keyspace");
        $info = $infoDb["db" . $this->redisDatabaseNumber] ?? 'keys=0';
        $countKeys = explode(
            '=',
            explode(',', $info)[0]
        )[1];
        return $countKeys;
    }
}
