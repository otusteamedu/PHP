<?php


namespace nvggit\hw26;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitWorker extends RabbitMq
{
    public function __construct(string $queue)
    {
        parent::__construct($queue);
    }

    private function doHardWork()
    {
        sleep(10);
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
    private function printJobDoneMsg(string $message)
    {
        echo " [x] Done task '{$message}'\n";
    }

    /**
     * @param AMQPMessage $msg
     */
    public function onResponse(AMQPMessage $msg)
    {
        $this->response = $msg->body;

        $this->printReceivedMsg($msg->body);

        $this->doHardWork();

        $this->printJobDoneMsg($msg->body);

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
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