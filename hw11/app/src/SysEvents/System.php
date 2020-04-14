<?php


namespace SysEvents;


use HW\Config;

class System
{
    const TABLE_PRIOR = 'priorities';
    const PREFIX_EVENT = 'event@';
    const PREFIX_COND = 'cond@';

    /** @var static  */
    private static $instance = null;

    /** @var \Redis  */
    private $db = null;

    private function __construct()
    {
        $this->db = new \Redis();

        $cfg = Config::redis();
        $this->db->connect($cfg['host'], $cfg['port']);
    }

    public static function inst()
    {
        if (!self::$instance)
            self::$instance = new self();
        return self::$instance;
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function clearAll()
    {
        $this->db->flushAll();
    }


    /**
     * @param Event $event
     */
    public function addEvent($event)
    {
        $hash = microtime();

        foreach ($event->getCondition()->toArray() as $param => $val)
            $this->db->hSet(self::PREFIX_COND . $hash, $param, $val);

        foreach ($event->toArray() as $key => $val)
            $this->db->hSet(self::PREFIX_EVENT . $hash, $key, $val);

        return $this->db->zAdd(self::TABLE_PRIOR, $event->getPriority(), $hash);
    }


    /**
     * @param array $conditions
     * @return Event|null
     */
    public function selectEvent($conditions)
    {
        /** @var Event  $event */
        $event = null;
        foreach ($this->listEventsHashes() as $hash => $priority) {
            $cond = $this->getCondition($hash);

            if ($cond && $cond->validate($conditions)) {

                $eventData = $this->db->hGetAll(self::PREFIX_EVENT . $hash);
                if (empty($eventData))
                    return null;

                $event = new Event($priority, $eventData);
                $event->setCondition($cond);
                break;
            }
        }
        return $event;
    }


    private function getCondition($eventHash)
    {
        $data = $this->db->hGetAll(self::PREFIX_COND . $eventHash);
        if (empty($data))
            return null;

        return new Condition($data);
    }

    public function listEventsHashes()
    {
        $list = $this->db->zRevRange(self::TABLE_PRIOR, 0, -1, true);
        return $list;
    }

}