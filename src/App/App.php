<?php

namespace Ozycast\App;

use Ozycast\App\Core\Cache;
use Ozycast\App\Core\CacheRedis;
use Ozycast\App\Models\Event;

Class App
{
    public static $cache = null;

    public function __construct()
    {
        self::getCache();
    }

    public function run()
    {
        if (!isset($_SERVER['argv']) && !isset($_SERVER['argv'][1]))
            return "Empty argument";

        switch ($_SERVER['argv'][1]) {
            case "addEvents":
                $events = json_decode($_SERVER['argv'][2], JSON_OBJECT_AS_ARRAY);
                $answer = Event::addEvents($events);
                break;

            case "findEvents":
                $params = json_decode($_SERVER['argv'][2], JSON_OBJECT_AS_ARRAY);
                $answer = Event::findEvents($params['params']);
                break;

            case "events":
                $answer = Event::events();
                break;

            case "clearAll":
                $answer = App::$db->clear();
                break;
        }

        if (!isset($answer))
            $this->showMessage("Command not fount");

        $this->showMessage($answer['message'], $answer['data']);
    }

    public function getCache(): Cache
    {
        self::$cache = (new CacheRedis())->connect();
        return self::$cache;
    }

    public function showMessage($message, $data = [])
    {
        print_r($message."\n\r");
        print_r($data);
    }
}