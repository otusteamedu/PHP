<?php


namespace Repetitor202\Domain\Repositories\Events;


use Redis;
use Repetitor202\Application\Clients\KeyValueStorages\Connections\RedisConnection;
use Repetitor202\Domain\DTO\EventSearchDTO;
use Repetitor202\Domain\DTO\EventStoreDTO;

class EventsRedisRepository implements IEventsRepository
{
    public const STORAGE_NAME = 'Redis';

    private const KEY_EVENT = 'event';

    private const KEY_PRIORITIES = 'events:priorities';

    private const KEY_NAMES = 'events:names';

    private function getClient(): ?Redis
    {
        return RedisConnection::getClient();
    }

    public function search(EventSearchDTO $searchDto): ?string
    {
        $IDs = $this->getClient()->hKeys(self::KEY_PRIORITIES);

        foreach ($IDs as $id) {
            foreach ($searchDto->conditions as $key => $value) {
                $match = true;
                if(
                    !$this->getClient()->hGet(self::KEY_EVENT . ':' . $id . ':params', $key) ||
                    $this->getClient()->hGet(self::KEY_EVENT . ':' . $id . ':params', $key) != $value
                ) {
                    $match = false;
                }
            }

            if($match) {
                $priority = $this->getClient()->hGet(self::KEY_PRIORITIES, $id);
                $this->getClient()->zAdd(self::KEY_PRIORITIES . '-match', $priority, $id);
            }
        }

        $eventMaximumPriority = $this->getClient()->zRange(self::KEY_PRIORITIES . '-match', -1, -1);

        if(!count($eventMaximumPriority)) {
            return null;
        }
        $idMaximumMatch = $eventMaximumPriority[0];

        $name = $this->getClient()->hGet(self::KEY_NAMES, $idMaximumMatch);

        $this->getClient()->del(self::KEY_PRIORITIES . '-match');

        return $name;
    }

    public function insert(EventStoreDTO $storeDto): array
    {
        $id = $storeDto->id;

        $transaction = $this->getClient()->multi()
            ->hset(self::KEY_PRIORITIES, $id, $storeDto->priority)
            ->hset(self::KEY_NAMES, $id, $storeDto->name)
        ;

        foreach ($storeDto->conditions as $key => $value) {
            $transaction->hSet(self::KEY_EVENT . ':' . $id . ':params', $key, $value);
        }

        return $transaction->exec();
    }

    public function clean(): bool
    {
        $number = $this->getClient()->del($this->getClient()->keys(self::KEY_EVENT . '*'));

        if(is_numeric($number) && $number > 0) {
            return true;
        }

        return false;
    }
}