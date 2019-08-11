<?php


namespace nvggit\hw26\rabbit;

use nvggit\hw26\App;
use nvggit\hw26\models\Task;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitWorker extends RabbitMq
{
    public function __construct(string $queue)
    {
        parent::__construct($queue);
    }

    private function doHardWork()
    {
        sleep(15);
    }

    /**
     * @param string $message
     */
    private function printReceivedMsg(string $message)
    {
        echo " [x] Received task '{$message}'\n";
    }

    /**
     * @param string $message
     */
    public function printUpdateStatus(int $status)
    {
        echo " [x] Task change status to " . Task::$statuses[$status] . "\n";
    }


    /**
     * @param AMQPMessage $msg
     * @throws \Exception
     */
    public function onResponse(AMQPMessage $msg)
    {
        $this->response = $msg->body;

        $this->printReceivedMsg($msg->body);

        App::getInstance()[$msg->get('correlation_id')] = Task::TYPE_FROG_HARD_WORK . Task::STATUS_PENDING;
        $this->replyResponse($msg, Task::TYPE_FROG_HARD_WORK . Task::STATUS_PENDING);
        $this->printUpdateStatus(Task::STATUS_PENDING);

        $this->doHardWork();

        App::getInstance()[$msg->get('correlation_id')] = Task::TYPE_FROG_HARD_WORK . Task::STATUS_COMPLETED;
        $this->replyResponse($msg, Task::TYPE_FROG_HARD_WORK . Task::STATUS_COMPLETED);
        $this->printUpdateStatus(Task::STATUS_COMPLETED);

        $msg->delivery_info['channel']->basic_ack(
            $msg->delivery_info['delivery_tag']
        );
    }

    /**
     * @param AMQPMessage $msg
     */
    public function replyResponse(AMQPMessage $msg, $responseMsg)
    {
        $msg->delivery_info['channel']->basic_publish(
            new AMQPMessage(
                $responseMsg,
                array('correlation_id' => $msg->get('correlation_id'))
            ),
            '',
            $msg->get('reply_to')
        );
    }

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