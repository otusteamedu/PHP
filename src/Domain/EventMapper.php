<?php

namespace App\Domain;

use App\Redis;

class EventMapper
{
    protected Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function save(Event $event): void
    {
        if (null === $event->id) {
            $event->id = uniqid($_SERVER['HOSTNAME'], true);
        } else {
            $this->delete($event->id);
        }
        $this->redis->set("event:{$event->id}", serialize($event));
        $this->redis->zAdd('weight', [], $event->priority, $event->id);
        foreach ($event->conditions as $key => $value) {
            $this->redis->sAdd(static::conditionToIndex($key, $value), $event->id);
        }
    }

    public function load(string $id): ?Event
    {
        $event = $this->redis->get("event:$id");
        return $event ? unserialize($event, ['allowed_classes' => [Event::class]]) : null;
    }

    public function delete(string $id): void
    {
        $event = $this->load($id);
        if (!$event) {
            return;
        }
        foreach ($event->conditions as $key => $value) {
            $this->redis->sRem(static::conditionToIndex($key, $value), $event->id);
        }
        $this->redis->zRem('weight', $event->id);
        $this->redis->del("event:{$event->id}");
    }

    /**
     * @param array $params
     * @return \App\Domain\Event|null
     * @phan-suppress PhanTypeMismatchReturn
     * @phan-suppress PhanTypeExpectedObjectPropAccess
     */
    public function find(array $params): ?Event
    {
        if (!$params) {
            return null;
        }
        $keys = array_map(
            [$this, 'conditionToIndex'],
            array_keys($params),
            $params
        );
        // id событий которые могут нам подойти - без сортировки
        $ids = $this->redis->sUnion(...$keys);
        // временно сохраним их чтобы можно было получить отсортированный вариант
        $temp_key = uniqid($_SERVER['HOSTNAME'] . '.' . 'temp', true);
        $temp_set = [];
        foreach ($ids as $id) {
            $temp_set[] = 0;
            $temp_set[] = $id;
        }
        $this->redis->zAdd($temp_key, [], ...$temp_set);
        unset($temp_set, $ids);
        // получим отсортированный в нужном порядке массив id событий
        $this->redis->zInterStore($temp_key . '.sorted', ['weight', $temp_key], null, 'MAX');
        $ids = $this->redis->zRevRange($temp_key . '.sorted', 0, -1);
        // перебираем до тех пор пока не найдем подходящее событие
        $result = null;
        foreach ($ids as $id) {
            $event = $this->load($id);
            if ($event && count(array_intersect($event->conditions, $params)) === count($event->conditions)) {
                $result = $event;
                break;
            }
        }
        // удаляем временные записи
        $this->redis->del($temp_key, $temp_key . '.sorted');
        return $result;
    }

    public static function conditionToIndex(string $key, $value): string
    {
        return 'index:' . base64_encode($key) . ':' . base64_encode(serialize($value));
    }
}
