<?php

namespace Otus;

use Redis;

class Event
{
    private Redis $client;

    private string $key;

    public ?int $priority;

    public ?array $conditions;

    public ?string $event;

    public function __construct()
    {
        $this->client = RedisClientFactory::make();
        $this->key    = md5(microtime(true));
    }

    /**
     * @param  array  $data
     *
     * @throws \JsonException
     * @throws \Otus\Exceptions\InvalidEventDataException
     * @return $this
     */
    public function save(array $data): self
    {
        $data = EventSanitizer::sanitize($data);

        return $this->saveEvent($data)
                    ->buildReverseIndex($data)
                    ->fill($data);
    }

    /**
     * @param  array  $data
     *
     * @throws \JsonException
     * @return $this
     */
    private function saveEvent(array $data): self
    {
        $this->client->set($this->getEventKey(), json_encode($data, JSON_THROW_ON_ERROR));

        return $this;
    }

    private function buildReverseIndex(array $data): self
    {
        $conditions = $this->prepareStoreConditions($data['conditions'], $data['priority']);

        foreach ($conditions as $key => $condition) {
            $this->client->zAdd($key, $condition, $this->getEventKey());
        }

        return $this;
    }

    private function prepareStoreConditions(array $conditions, int $priority): array
    {
        $result = [];

        foreach ($conditions as $key => $val) {
            $result[$key.':'.$val] = $priority;
        }

        return $result;
    }

    private function getEventKey(): string
    {
        return 'event'.$this->key;
    }

    public function fill(array $data): self
    {
        $this->priority   = $data['priority'];
        $this->conditions = $data['conditions'];
        $this->event      = $data['event'];

        return $this;
    }

    /**
     * @param  array  $conditions
     *
     * @throws \JsonException
     * @return $this
     */
    public function get(array $conditions): self
    {
        $this->client->zinterstore('result', $this->prepareSearchConditions($conditions));
        $events = $this->client->zPopMax('result', 1);

        $data = json_decode($this->client->get(array_key_first($events)), true, 512, JSON_THROW_ON_ERROR);

        return $this->fill($data);
    }

    private function prepareSearchConditions(array $conditions): array
    {
        $result = [];

        foreach ($conditions as $key => $val) {
            $result[] = $key.':'.$val;
        }

        return $result;
    }

    public function flush(): bool
    {
        return $this->client->flushDB();
    }
}
