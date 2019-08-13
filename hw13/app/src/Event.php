<?php
/**
* Class describes all Event entity behaviour
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys;

class Event
{
    /**
    * @var array - editable class properites
    */
    private static $fillable = [
        'event',
        'conditions',
        'priority'
    ];

    /**
    * @var array - redis keys templates
    */
    private static $redisKeyTpl = [
        'last_id' => 'current_event_id',
        'event_data' => 'event:#event_id#:data',
        'event_priority' => 'event:#event_id#:priority',
        'event_conditions' => 'event:#event_id#:conditions',
        'conditions' => 'conditions:#param_name#:#param_val#'
    ];

    /**
    * @var int - event id
    */
    private $id;

    /**
    * @var array - event description
    */
    private $event;

    /**
    * @var array - event conditions
    */
    private $conditions;

    /**
    * @var int - event priority
    */
    private $priority;

    /**
    * @var Jekys\Redis - redis connection
    */
    private $redis;

    /**
    * Class entity constructor
    *
    * @return void
    */
    public function __construct()
    {
        $this->redis = Redis::getInstance();
    }

    /**
    * Magic setter for properties
    * Sets only properties in $fillable
    *
    * @param string $param - property name
    * @param string $value - property value
    *
    * @return void
    */
    public function __set(string $param, mixed $value): void
    {
        if (property_exists($this, $param) && in_array($param, self::$fillable)) {
            $this->{$param} = $value;
        }
    }

    /**
    * Magic getter for private class properties
    *
    * @param string $param - property name
    *
    * @return mixed
    */
    public function __get(string $param): mixed
    {
        if (property_exists($this, $param)) {
            return $this->{$param};
        }
    }

    /**
    * Redis key preparation for request
    *
    * @param string $key - redis key code
    * @param array $params - array of replacers
    *
    * @return string
    */
    private static function prepareKey(string $key, $params = []): string
    {
        if (!array_key_exists($key, self::$redisKeyTpl)) {
            throw new \Exception('Key '.$key.' doesn`t exists');
        }

        $preparedKey = self::$redisKeyTpl[$key];
        foreach ($params as $param => $value) {
            $preparedKey = str_replace('#'.$param.'#', $value, $preparedKey);
        }

        return $preparedKey;
    }

    /**
    * Save all object data to the redis
    *
    * @return int - event id
    */
    public function save(): int
    {
        $lastIdKey = self::prepareKey('last_id');
        if (!$this->id) {
            $this->redis->incr($lastIdKey);
            $this->id = $this->redis->get($lastIdKey);
        }

        $this->redis->set(
            self::prepareKey(
                'event_priority',
                [
                    'event_id' => $this->id
                ]
            ),
            $this->priority
        );

        $this->redis->hMset(
            self::prepareKey(
                'event_data',
                [
                    'event_id' => $this->id
                ]
            ),
            $this->event
        );

        $this->redis->hMset(
            self::prepareKey(
                'event_conditions',
                [
                    'event_id' => $this->id
                ]
            ),
            $this->conditions
        );

        foreach ($this->conditions as $condition => $value) {
            $this->redis->sadd(
                self::prepareKey(
                    'conditions',
                    [
                        'param_name' => $condition,
                        'param_val' => $value
                    ]
                ),
                $this->id
            );
        }

        return $this->id;
    }

    /**
    * Load event data from redis to the object properties
    *
    * @param int $eventId
    *
    * @return void
    */
    private function load(int $eventId): void
    {
        $this->id = $eventId;

        $this->priority = $this->redis->get(
            self::prepareKey(
                'event_priority',
                [
                    'event_id' => $this->id
                ]
            )
        );

        $this->event = $this->redis->hgetAll(
            self::prepareKey(
                'event_data',
                [
                    'event_id' => $this->id
                ]
            )
        );

        $this->conditions = $this->redis->hgetAll(
            self::prepareKey(
                'event_conditions',
                [
                    'event_id' => $this->id
                ]
            )
        );
    }

    /**
    * Create Event object from array and store it in the redis
    *
    * @param array $data - array of event properties
    *
    * @return Event
    */
    public static function create(array $data): Event
    {
        $event = new self;

        foreach (self::$fillable as $key) {
            if (!array_key_exists($key, $data)) {
                throw new \Exception($key.' parametr doesn`t exists');
            } else {
                $event->{$key} = $data[$key];
            }
        }

        $event->save();

        return $event;
    }

    /**
    * Return Event object via event id
    *
    * @param int $eventId
    *
    * @return Event
    */
    public static function find(int $eventId): Event
    {
        $event = new self;
        $event->load($eventId);

        return $event;
    }

    /**
    * Delete all event data from redis
    *
    * @return void
    */
    public static function dropAll(): void
    {
        $redis = Redis::getInstance();

        $params = [
            'event_id' => '*',
            'param_name' => '*',
            'param_val' => '*'
        ];

        $keys = [];

        foreach (self::$redisKeyTpl as $keyTplCode => $keyTpl) {
            $keys = array_merge(
                $keys,
                self::prepareKey(
                    $keyTplCode,
                    $params
                )
            );
        }

        foreach ($keys as $key) {
            $redis->del($key);
        }
    }

    /**
    * Return the best Event for current conditions
    *
    * @param array $conditions - array of params
    *
    * @return Event|null
    */
    public static function getRelevant(array $conditions)
    {
        $result = null;

        $redis = Redis::getInstance();

        $eventIds = [];

        foreach ($conditions as $key => $value) {
            $eventIds = array_merge(
                $eventIds,
                $redis->smembers(
                    self::prepareKey(
                        'conditions',
                        [
                            'param_name' => $key,
                            'param_val' => $value
                        ]
                    )
                )
            );
        }

        $eventIds = array_unique($eventIds);

        $priority = 0;

        foreach ($eventIds as $eventId) {
            $event = self::find($eventId);

            $intersect = array_intersect($conditions, $event->conditions);

            if (count($intersect) === count($event->conditions) && $event->priority > $priority) {
                $result = $event;
                $priority = $event->priority;
            }
        }

        return $result;
    }
}
