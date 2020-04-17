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
        $ids = $this->redis->sUnion(...$keys);
        $events = array_flip($ids);
        array_walk(
            $events,
            function (&$el, $id) {
                $el = $this->load($id);
            }
        );
        usort($events, fn($a, $b) => $a->priority < $b->priority);
        /** @var Event $event */
        foreach ($events as $event) {
            if (count(array_intersect($event->conditions, $params)) === count($event->conditions)) {
                return $event;
            }
        }
        return null;
    }

    public static function conditionToIndex($key, $value): string
    {
        return "index:$key:" . base64_encode(serialize($value));
    }
}
