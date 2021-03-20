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

    private array $identityMapParams = [];

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
                    $this->getParamValueFromIdentityMap($id, $key) != $value
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
            if($this->insertParamIntoIdentityMap($id, $key, $value)) {
                $transaction->hSet(self::KEY_EVENT . ':' . $id . ':params', $key, $value);
            }
        }

        return $transaction->exec();
    }

    public function clean(): bool
    {
        $this->identityMapParams = [];

        $number = $this->getClient()->del($this->getClient()->keys(self::KEY_EVENT . '*'));

        if(is_numeric($number) && $number > 0) {
            return true;
        }

        return false;
    }

    private function getParamValueFromIdentityMap(int $id, string $param): ?string
    {
        if(is_null($this->identityMapParams[$id])) {
            $this->identityMapParams[$id] = [];
        }

        $paramValue = $this->identityMapParams[$id][$param];

        if(is_null($paramValue)) {
            $paramValue = $this->getClient()->hGet(self::KEY_EVENT . ':' . $id . ':params', $param);
            $this->identityMapParams[$id][$param] = $paramValue;
        }

        return $this->identityMapParams[$id][$param];
    }

    private function insertParamIntoIdentityMap($id, $param, $paramValue): bool
    {
        if(is_null($this->identityMapParams[$id])) {
            $this->identityMapParams[$id] = [];
        }

        if(is_null($this->identityMapParams[$id][$param])) {
            $this->identityMapParams[$id][$param] = $paramValue;

            return true;
        }

        return false;
    }
}