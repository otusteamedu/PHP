<?php

namespace App\Models;

//require_once __DIR__ . '/../../autoload.php';


class Analitic
{
    protected $events = [];
    protected static $connection;

    public static function getInstance()
    {
        if (static::$connection === null) {
            static::$connection = new static();
        }
        return static::$connection;
    }


    protected function __construct()
    {
        $this->events = DBRedis::getAll();
    }

    public function addEvent(int $priority, array $conditions, string $event)
    {
        $obj = new Event($priority, $conditions, $event);
        $this->events[] = $obj;
        DBRedis::add($this->events);
    }
}