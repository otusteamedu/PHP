<?php


namespace Otus\Storage;

use Otus\DTO\EventDTO;
use Otus\DTO\UserRequestDTO;
use Otus\Exceptions\AppException;
use Redis;

class RedisDAO implements StorageInterface
{
    const STORAGE_NAME = 'redis';
    const KEY = 'events:';

    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
    }

    public function find(UserRequestDTO $userRequestDTO): ?EventDTO
    {
        $sets = $this->findEvents($userRequestDTO->getConditions());
        $eventIDs = $this->findSuitableEvents($userRequestDTO->getConditions(), $sets);
        $raw = $this->getEventMaxPriority($eventIDs);
        $eventData = $this->redis->get($this->generateKeyEvent($raw['event_id']));
        $conditions = $this->redis->sMembers($this->generateKeyConditions($raw['event_id']));

        $eventDTO = new EventDTO();
        $eventDTO->setId($raw['event_id']);
        $eventDTO->setConditions($conditions);
        $eventDTO->setPriority($raw['priority']);
        $eventDTO->setEvent($eventData);

        return $eventDTO;
    }

    public function save(EventDTO $event)
    {
        $key = $this->generateKey($event->getId());

        $partOne = $this->redis->multi()
            ->zAdd($this->generatePriority(), [], $event->getPriority(), $key)
            ->set($this->generateKeyEvent($event->getId()), $event->getEvent())
            ->exec();

        $this->redis->multi();

        foreach ($event->getConditions() as $condition) {
            $this->redis->sAdd($this->generateKeyConditions($event->getId()), $condition);
            $this->redis->sAdd($this->generateHelperConditions($condition), $key . ':conditions');
        }

        $partTwo = $this->redis->exec();
        return array_merge($partOne, $partTwo);
    }

    public function delete(): bool
    {
        return $this->redis->del($this->redis->keys(self::KEY . '*'));
    }

    private function findEvents(array $conditions): array
    {
        $sets = [];
        foreach ($conditions as $item) {
            $item = $this->generateHelperConditions($item);
            $buf = $this->redis->sMembers($item);

            foreach ($buf as $keyConditions) {
                $sets[$keyConditions] = [
                    'number' => $this->redis->sCard($keyConditions),
                    'suitable_number' => 0
                ];
            }
        }

        if (empty($sets)) {
            throw new AppException('No sets found');
        }

        return $sets;
    }

    private function findSuitableEvents(array $conditions, array $sets): array
    {
        foreach ($sets as $keyConditions => &$item) {
            foreach ($conditions as $condition) {
                $result = $this->redis->sIsMember($keyConditions, $condition);
                if ($result) {
                    $item['suitable_number']++;
                }
            }
        }

        $eventIDs = [];
        foreach ($sets as $keyConditions => $item)  {
            if ($item['number'] == $item['suitable_number']) {
                $eventID = $this->getEventIDFromKeyConditions($keyConditions);
                $key = $this->generateKey($eventID);
                $eventIDs[$key] = [
                    'priority' => $this->redis->zScore($this->generatePriority(), $key),
                    'event_id' => $eventID
                ];
            }
        }

        return $eventIDs;
    }

    private function getEventMaxPriority(array $eventIDs): array
    {
        $scores = array_column($eventIDs, 'priority');
        $maxPriority = max($scores);
        foreach ($eventIDs as $item) {
            if ($item['priority'] == $maxPriority) {
                $eventID = $item['event_id'];
                break;
            }
        }

        return ['priority' => $maxPriority, 'event_id' => $eventID];
    }

    private function getEventIDFromKeyConditions(string $keyConditions): string
    {
        $result = explode(':', $keyConditions);
        if (empty($result[1])) {
            throw new AppException('Redis is not structured correctly.');
        }
        return $result[1];
    }

    private function generateKey($id)
    {
        return self::KEY . $id;
    }

    private function generateKeyConditions(string $id): string
    {
        return $this->generateKey($id) . ':conditions';
    }

    private function generateKeyEvent(string $id): string
    {
        return $this->generateKey($id) . ':event';
    }

    private function generateHelperConditions(string $item): string
    {
        return self::KEY . $item;
    }

    private function generatePriority(): string
    {
        return self::KEY . ':priority';
    }

    public function __destruct()
    {
        $this->redis->close();
    }


}