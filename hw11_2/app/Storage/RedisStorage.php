<?php

namespace App\Storage;

use App\Contracts\Storage;
use App\Entities\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Predis\Response\Status;

class RedisStorage implements Storage
{
    /**
     * @inheritDoc
     */
    public function find(array $params): ?Event
    {
        $names = Redis::keys('*');

        $foundEvents = new Collection();

        foreach ($names as $name) {
            $data = Redis::hgetall($name);
            $data['priority'] = (int)$data['priority'];
            $data['conditions'] = json_decode($data['conditions'], true);

            $matchedConditions = [];

            foreach ($data['conditions'] as $condition) {
                foreach ($params as $param) {
                    if ($condition === $param) {
                        $matchedConditions[] = $condition;
                    }
                }
            }

            if ($matchedConditions === $params) {
                $foundEvents->push($data);
            }
        }

        $maxPriority = $foundEvents->max('priority');
        $highestPriorityEvent = $foundEvents->firstWhere('priority', $maxPriority);

        if ($highestPriorityEvent === null) {
            return null;
        }

        return (new Event)
            ->setName($highestPriorityEvent['name'])
            ->setPriority($highestPriorityEvent['priority'])
            ->setConditions($highestPriorityEvent['conditions']);
    }

    /**
     * @inheritDoc
     */
    public function insert(Event $event): bool
    {
        /** @var Status $status */
        $status = Redis::hmset($event->getName(), [
            'name' => $event->getName(),
            'priority' => $event->getPriority(),
            'conditions' => json_encode($event->getConditions()),
        ]);
        $payload = $status->getPayload();

        return $payload === 'OK';
    }

    public function clear(): void
    {
        Redis::flushAll();
    }
}
