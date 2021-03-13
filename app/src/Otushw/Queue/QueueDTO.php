<?php


namespace Otushw\Queue;

class QueueDTO
{

    public QueueConnectionInterface $queueConnection;
    public QueueInstance $instance;

    public function __construct(
        QueueConnectionInterface $queueConnection,
        QueueInstance $instance
    )
    {
        $this->queueConnection = $queueConnection;
        $this->instance = $instance;
    }
}