<?php


namespace App\Services\Events;


use App\Services\Events\Repositories\Interfaces\CacheEventRepositoryInterface;

class EventService
{
    private CacheEventRepositoryInterface $cache_event_repository;

    public function __construct(CacheEventRepositoryInterface $cache_event_repository)
    {
        $this->cache_event_repository = $cache_event_repository;
    }

    public function store(array $data): bool
    {
        $event = $data['event_name'];
        $priority = $data['priority'];
        $conditions = $data['conditions'];
        $key = $this->getKet($conditions);
        return $this->cache_event_repository->store($key, $priority, $event);
    }

    public function getOne(array $conditions): ?string
    {
        $key = $this->getKet($conditions);
        return $this->cache_event_repository->getOne($key);
    }

    public function flush(): bool
    {
        return $this->cache_event_repository->flush();
    }

    private function getKet(array $conditions)
    {
        if (!empty($conditions)) {
            $key = [];
            foreach ($conditions as $condition) {
                array_push($key, $condition['key'], $condition['value']);
            }
            return implode(':', $key);
        }
        return false;
    }
}
