<?php


namespace nvggit\hw26\rabbit;


use nvggit\hw26\App;
use nvggit\hw26\models\Task;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitClient extends RabbitMq
{
    public function __construct(string $queue)
    {
        parent::__construct($queue);
    }

    /**
     * @param string $message
     */
    public function printCorrIdMsg()
    {
        echo " [x] Task added to queue, correlation_id is '{$this->corrId}'\n";
    }


    /**
     * @param AMQPMessage $msg
     */
    public function onResponse(AMQPMessage $msg)
    {
        echo " [x] Received task update '{$msg->body}'\n";

        App::getInstance()[$msg->get('correlation_id')] = $msg->body;
    }

    /**
     * @param string $message
     * @return bool
     * @throws \Exception
     */
    public function addTask(Task $task): string
    {
        $this->connect();
        $this->setChannel();
        $this->declareChannel();
        $msg = $this->createMsg($task->type . $task->status);
        $this->publishMsg($msg);
        $correlation_id = $this->printCorrIdMsg();
        App::getInstance()[$correlation_id] = $task->type . $task->status;
        $this->channel->close();
        $this->connection->close();
        return $this->corrId;
    }

    /**
     * @throws \ErrorException
     */
    public function listen()
    {
        $this->connect();
        $this->setChannel();
        $this->declareChannel();

        $this->basicQos();
        $this->consumeChannel();

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }
}