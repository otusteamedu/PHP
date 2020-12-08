<?php

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
        $this->queue->recive('test', $this->logger());
    }

    public function logger($msg){
        print_r([
            'message' => json_decode($msg)
        ]);
    }
}