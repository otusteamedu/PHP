<?php

namespace Ozycast\App\Core;

use Redis;

/**
 * Работа с очередями через Redis
 *
 * Class RabbitQueue
 * @package Ozycast\App\Core
 */
class RedisQueue implements Queue
{
    /**
     * @var Redis
     */
    public $connect = null;

    /**
     * @return Queue
     */
    public function connect(): Queue
    {
        if ($this->connect) {
            return $this;
        }

        $host = $_ENV["REDIS_HOST"];
        $port = $_ENV["REDIS_PORT"];

        $this->connect = new Redis();
        $this->connect->connect($host, $port);
        return $this;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function getChannel($id)
    {
        return true;
    }

    /**
     * @param ?$channel
     * @param string $queue
     * @param string $message
     */
    public function send($channel, $queue, string $message)
    {
        $this->connect->rPush($queue, $message);
    }

    /**
     * @param string $channel
     * @param string $queue
     */
    public function addConsumer($channel, $queue)
    {
        $msg = $this->connect->blPop($queue, 10);
        RouteQueue::dispatch($msg[1]);

        while ($msg) {
            $this->addConsumer($channel, $queue);
        }
    }
}