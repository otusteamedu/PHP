<?php

namespace storage;

interface IQueue
{
    /**
     * Отправить сообщение
     *
     * @param $queueName string название очереди
     * @param $msg       string тело сообщения
     *
     * @return mixed
     */
    public function send($queueName, $msg);


    /**
     * Получить данные из очереди
     *
     * @param $queueName string название очереди
     * @param $callback callable обработчик сообщений
     *
     * @return mixed
     */
    public function recive($queueName, $callback);
}