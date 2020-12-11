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
     *
     * @param $queueName string название очереди
     *
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function createQueue($queueName)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        return $this->channel;
    }


    /**
     * @inheritDoc
     */
    public function send($queueName, $msg)
    {
        $this->createQueue($queueName)->basic_publish(new AMQPMessage($msg, ['delivery_mode' => 2]), '', self::EXCHANGE_ROUTING);
    }


    /**
     * @inheritDoc
     */
    public function recive($queueName, $callback)
    {
        $channel = $this->createQueue($queueName);

        /**
         * не отправляем новое сообщение на обработчик, пока он
         * не обработал и не подтвердил предыдущее. Вместо этого
         * направляем сообщение на любой свободный обработчик
         */
        $channel->basic_qos(
            null,   #размер предварительной выборки - размер окна предварительнйо выборки в октетах, null означает “без определённого ограничения”
            1,      #количество предварительных выборок - окна предварительных выборок в рамках целого сообщения
            null    #глобальный - global=null означает, что настройки QoS должны применяться для получателей, global=true означает, что настройки QoS должны применяться к каналу
            );

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
    }
}