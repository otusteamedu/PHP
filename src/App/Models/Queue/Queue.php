<?php

namespace Ozycast\App\Models\Queue;

use Ozycast\App\App;

class Queue
{
    const CHANEL_NAME = "";
    protected static $channel = null;
    
    /**
     * Получить канал
     * @return null
     */
    public static function getChannel()
    {
        if (!static::$channel)
            static::$channel = App::getQueue()->getChannel(static::CHANEL_NAME);

        return static::$channel;
    }

    /**
     * Добавить заказ в очередь на обработку
     * @param $message
     */
    public static function add($message)
    {
        App::getQueue()->send(self::getChannel(), static::QUEUE_NAME, $message);
    }

    /**
     * Добавить обработчика очереди
     */
    public static function addConsumer()
    {
        App::getQueue()->addConsumer(self::getChannel(), static::QUEUE_NAME);
    }
}