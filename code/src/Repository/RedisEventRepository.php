<?php


namespace App\Repository;


use App\Model\Builders\EventBuilder;
use App\Model\Interfaces\ModelEventInterface;
use Psr\Container\ContainerInterface;
use Redis;

class RedisEventRepository implements Interfaces\EventRepositoryInterface
{
    // table
    const LIST_NAME = 'events';
    const EVENT_KEY_PREFIX = 'event:';

    // indices
    const INDEX_PREFIX = 'event';
    const SET_INDEX_KEY = 'events.indices';

    const EVENT_LAST_ID = 'event_last_id';

    private Redis $redis;
    private EventBuilder $builder;

    /**
     * RedisEventRepository constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->redis = $container->get('redis');
        $this->builder = new EventBuilder();
    }

    public function create(ModelEventInterface $model): ModelEventInterface
    {
        $id = $this->redis->incr(self::EVENT_LAST_ID);

        $eventKey = $this->getEventKey($id);
        $hashKeys = array_merge(['id' => $id], $model->toArray());

        $this->redis->hMSet($eventKey, $hashKeys);

        $this->createIndices($model->getCondition(), $eventKey);

        $this->redis->lPush(self::LIST_NAME, $eventKey);

        $model->setId($id);
        return $model;
    }

    public function findOne(int $id): ModelEventInterface
    {
        $event = $this->redis->hGetAll($this->getEventKey($id));
        return $this->builder->build($event);
    }

    public function findAll(): array
    {
        $models = [];

        $items = $this->redis->lRange(self::LIST_NAME, 0, -1);
        foreach ($items as $item) {
            $event = $this->redis->hGetAll($item);
            $model = $this->builder->build($event);
            array_push($models, $model);
        }

        return $models;
    }

    public function findByParams(array $params): array
    {
        $models = [];
        foreach ($params as $key => $value) {
            $items = $this->redis->zRangeByScore(
                $this->getIndexName($key),
                $value, $value
            );

            foreach ($items as $item) {
                $event = $this->redis->hGetAll($item);
                $model = $this->builder->build($event);
                array_push($models, $model);
            }
        }
        return $models;
    }

    public function findMaxPriorityByParams(array $params): ?ModelEventInterface
    {
        $id = 0;
        $priority = 0;
        foreach ($params as $key => $value) {
            $items = $this->redis->zRangeByScore(
                $this->getIndexName($key),
                $value, $value
            );

            foreach ($items as $item) {
                $eventId = $this->redis->hGet($item, 'id');
                $eventPriority = $this->redis->hGet($item, 'priority');
                if ($eventPriority > $priority) {
                    $id = $eventId;
                    $priority = $eventPriority;
                }
            }
        }

        if (!$id) {
            return null;
        }

        return $this->findOne($id);
    }

    public function drop(): bool
    {
        // delete items
        $items = $this->redis->lRange(self::LIST_NAME, 0, -1);
        $this->redis->del($items);
        $this->redis->del(self::LIST_NAME);

        // delete indices
        $indices = $this->redis->sMembers(self::SET_INDEX_KEY);
        $this->redis->del($indices);
        $this->redis->del(self::SET_INDEX_KEY);

        // delete counter
        $this->redis->del(self::EVENT_LAST_ID);

        return true;
    }

    private function createIndices(array $params, string $eventKey)
    {
        foreach ($params as $key => $val) {
            $indexName = $this->getIndexName($key);
            $this->redis->zAdd(
                $indexName,
                $val,
                $eventKey
            );
            $this->redis->sAdd(self::SET_INDEX_KEY, $indexName);
        }
    }

    private function getIndexName(string $fieldName): string
    {
        return sprintf('%s.%s.index', self::INDEX_PREFIX, $fieldName);
    }

    private function getEventKey($id): string
    {
        return self::EVENT_KEY_PREFIX . $id;
    }
}
