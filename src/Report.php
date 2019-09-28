<?php
namespace AlexRedis;


class Report
{

    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->pconnect('127.0.0.1', 6379);
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    /**
     * Just for check that we have connect
     */
    public function testRedis()
    {
        echo 'We send "hello" to Redis and Redis answer to us: ' .$this->redis->ping('hello');
    }

    /*
     * Destroy all data in Redis
     */
    public function destroyAll()
    {
        $this->redis->flushAll();
    }

    /**
     * @param array $event
     * @return bool
     * @throws \Exception
     */
    public function addEvent(array $event)
    {

        if (empty($event)) {
            throw new \Exception('Event must be not empty');
        }

        $required_keys = [
            'priority',
            'conditions',
            'event'
        ];

        $event_keys = array_keys($event);

        if (!empty($diff = array_diff($required_keys, $event_keys))) {
            throw new \Exception('Required field is absent: ' . implode(',', $diff));
        }

        if (!is_array($event['conditions'])) {
            throw new \Exception('Conditions must be array of parameters');
        }

        foreach ($event as $k => $v) {
            if (empty($v)) {
                throw new \Exception('Required field ' .$k  .' is empty');
            }
        }

        $k = 1;
        $keyFind = 'event' . $k . ':priority';
        while($this->redis->hExists($keyFind, 'priority') !== false) {
            $k++;
            $keyFind = 'event' . $k . ':priority';
        }

        $key = 'event' . $k;
        foreach ($event as $k => $item) {
            $hkey = $key.':'.$k ;

            if (!is_array($item)) {
                $item = [$k => $item];
            }

            $this->redis->hMSet($hkey, $item);

        }
        return true;

    }


    /**
     * @param string $key
     * @param string $hashKey
     * @return array
     */
    public function getByKey(string $key, array $hashKey)
    {
        return $this->redis->hMGet($key, $hashKey);
    }


    /**
     * @param array $params
     * @return array
     */
    public function getEvent(array $params)
    {
        $it = NULL;
        $this->redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);
        $k = 1;
        $event = []; $last_priority = 0;
        while($arr_keys = $this->redis->hScan('event'.$k.':conditions', $it)) {
            if(empty(array_diff_assoc($params, $arr_keys))) {
                $current_priority = (int)$this->redis->hGet('event'.$k.':priority', 'priority');
                if ($current_priority > $last_priority) {
                    $last_priority = $current_priority;
                    $event = [
                        'priority' => $current_priority,
                        'conditions' => $arr_keys,
                        'description' => $this->redis->hGet('event'.$k.':event', 'description')
                    ];
                }
            }

            $k++;
            $it = null;
        }

        return $event;
    }

    /**
     * Print what we have in our events
     */
    public function printAllConditions()
    {
        $it = NULL;
        /* Don't ever return an empty array until we're done iterating */
        $this->redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);
        $k = 1;
        while($arr_keys = $this->redis->hScan('event'.$k.':conditions', $it)) {
            foreach($arr_keys as $str_field => $str_value) {
                echo "$k: $str_field => $str_value<br>"; /* Print the hash member and value */
            }
            $k++;
            $it = null;
        }
    }

    /**
     * Delete all events.
     * @return int return how much events was deleted
     */
    public function deleteEvents()
    {
        $k = 1;
        $keyFind = 'event' . $k . ':priority';
        while($this->redis->hExists($keyFind, 'priority') !== false) {
            $this->redis->hDel($keyFind, 'priority','conditions', 'event');
            $k++;
            $keyFind = 'event' . $k . ':priority';
        }

        return $k-1;
    }

}