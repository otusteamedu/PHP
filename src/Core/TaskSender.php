<?php

namespace App\Core;

use App\Services\RabbitMQ;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;

class TaskSender
{
    /**
     * @param string $taskName
     * @throws Exception
     */
    public function newTask(string $taskName): void
    {
        $channel = RabbitMQ::getAMQPChannel();
        $channel->queue_declare('task_queue', false, true, false, false);

        $msg = new AMQPMessage($taskName, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($msg, '', 'task_queue');

        RabbitMQ::closeChannelAndConnection();
    }

    protected function returnTaskNumber()
    {

    }
}