<?php


namespace nvggit\hw26;


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
        echo " [x] Task added to queue, CorrID is '{$this->corrId}'\n";
    }

    /**
     * @param AMQPMessage $msg
     */
    public function onResponse(AMQPMessage $msg)
    {
    }

    /**
     * @param string $message
     * @return bool
     * @throws \Exception
     */
    public function addTask(): string
    {
        $this->connect();
        $this->setChannel();
        $this->declareChannel();
        $this->publishMsg($this->createMsg($this->corrId));
        $this->printCorrIdMsg();
        $this->channel->close();
        $this->connection->close();

        return $this->corrId;
    }
}