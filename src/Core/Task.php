<?php

namespace App\Core;

use App\Services\RabbitMQ;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use SQLite3;

class Task
{
    public const TASK_IN_ORDER = 100;
    public const TASK_IS_PROCESSING = 200;
    public const TASK_WAS_FINISHED = 300;

    private ?SQLite3 $db;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->db = DbConnector::getInstance();
    }


    /**
     * @return int
     * @throws Exception
     */
    public function newTask(): int
    {
        $taskNumber = $this->writeAndReturnTaskNumber();

        $channel = RabbitMQ::getAMQPChannel();
        $channel->queue_declare('task_queue', false, true, false, false);

        $msg = new AMQPMessage($taskNumber, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($msg, '', 'task_queue');

        RabbitMQ::closeChannelAndConnection();

        return $taskNumber;
    }

    private function writeAndReturnTaskNumber(): int
    {
        $this->db->query("INSERT INTO tasks (status) VALUES ('100')");
        return $this->db->lastInsertRowID();
    }

    public function getTaskStatus(int $id): string
    {
        $statusNum = $this->db->querySingle("SELECT status FROM tasks WHERE id = '$id'");

        if (empty($statusNum)) {
            return 'Task not found!';
        }

        switch ($statusNum) {
            case static::TASK_IN_ORDER:
                return 'Task in order';
            case static::TASK_IS_PROCESSING:
                return 'Task is processing';
            case static::TASK_WAS_FINISHED:
                return 'Task was finished';
            default:
                return 'Internal problem. Create new task!';
        }
    }
}