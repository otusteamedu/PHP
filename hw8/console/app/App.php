<?php

use PhpAmqpLib\Message\AMQPMessage;

class App
{
    /**
     * @var \storage\IQueue
     */
    private $queue;

    public function __construct($config)
    {
        if (empty($config['queue'])) {
            throw new Exception('No queue config');
        }
        $queueConfig = $config['queue'];
        $qClass = $queueConfig['class'];
        unset($queueConfig['class']);
        $this->queue = new $qClass($queueConfig);
    }


    public function run(){
        $this->queue->recive('test', function(AMQPMessage $msg){

            print_r([
                'message' => $msg->body
            ]);

        });
    }

}