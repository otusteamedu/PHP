<?php

namespace Ozycast\App\Core;

interface Queue
{
    /**
     * Вернет подключение
     * @return Queue
     */
    public function connect(): Queue;

    /**
     * Отправить сообщение в очередь
     * @param $channel
     * @param $queue
     * @param string $message
     * @return mixed
     */
    public function send($channel, string $queue, string $message);

    /**
     * Добавить обработчика очереди
     * @param $channel
     * @param $queue
     * @return mixed
     */
    public function addConsumer($channel, string $queue);

    /**
     * Вернет канал
     * @param $id
     * @return mixed
     */
    public function getChannel($id);
}