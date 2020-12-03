<?php


namespace AYakovlev\Core;

use AYakovlev\Model\iEventModel;
use Redis;

class RedisBD implements iEventModel
{
    protected object $redis;
    protected string $name;
    protected int $priority;
    protected array $conditions;
    private static $instance;

    private function __construct()
    {
        $dbOptions = (require '../config/settings.php')['db'];
        $this->redis = new Redis();
        $this->redis->connect($dbOptions['host'], $dbOptions['port']);
    }

    public function addNoteToBD(): bool
    {
        return $this->redis->hMSet($this->name,
            [
                'name' => $this->name,
                'priority' => $this->priority,
                'conditions' => json_encode($this->conditions)
            ]
        );
    }

    public function resetAllDataFromBD()
    {
        $this->redis->flushAll();
    }

    public function setName(string $name): string
    {
        $this->name = $name;
        return $this->name;
    }

    public function setPriority(int $priority): int
    {
        $this->priority = $priority;
        return $this->priority;
    }

    public function setConditions(array $conditions): array
    {
        $this->conditions = $conditions;
        return $this->conditions;
    }

    // simple singleton for Db call, without clone and copy
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getBestEventByConditions(array $conditions): array
    {
        $eventNames = $this->redis->keys('*');
        $maxPriority = 0;
        $bestEventName = '';
        $matchedEventsData = [];
        foreach ($eventNames as $eventName) {
            $eventData = $this->redis->hGetAll($eventName);
            $eventConditions = json_decode($eventData['conditions'], JSON_OBJECT_AS_ARRAY);
            $countMatchedConditions = 0;
            foreach ($eventConditions as $key => $value) {
                if (
                    array_key_exists($key, $conditions)
                    && ($conditions[$key] == $value)
                ) {
                    $countMatchedConditions++;
                }
                if ($countMatchedConditions == count($eventConditions)) {
                    $matchedEventsData[$eventName] = $eventData;
                    if ($eventData['priority'] > $maxPriority) {
                        $maxPriority = $eventData['priority'];
                        $bestEventName = $eventName;
                    }
                }
            }
        }
        return $this->redis->hGetAll($bestEventName);
    }
}
