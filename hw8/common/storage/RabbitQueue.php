<?php

namespace storage;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueue implements IQueue
{
    const EXCHANGE_ROUTING = 'hw8';
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    protected $channel;


    /**
     * RabbitQueue constructor.
     *
     * @param $credentials array
     */
    public function __construct($credentials)
    {
        $this->connection = new AMQPStreamConnection($credentials['host'], $credentials['port'], $credentials['user'], $credentials['pass']);
        $this->channel    = $this->connection->channel();
    }


    /**
     * Закрываем соединения
     *
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }


    /**
     * Создаем очередь, если ее нет
     * @param $queueName string название очереди
     *
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function createQueue($queueName)
    {
        $this->channel->queue_declare($queueName, false, false, false, false);

        return $this->channel;
    }


    /**
     * @inheritDoc
     */
    public function send($queueName, $msg)
    {
        $this->createQueue($queueName)->basic_publish(new AMQPMessage($msg), '', self::EXCHANGE_ROUTING);
    }


    /**
     * @inheritDoc
     */
    public function recive($queueName, $callback)
    {
        $channel = $this->createQueue($queueName);
        $channel->basic_consume($queueName, '', false, true, false, false, $callback);
        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}