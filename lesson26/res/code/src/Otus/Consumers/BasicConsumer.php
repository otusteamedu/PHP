<?php


namespace Otus\Consumers;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class BasicConsumer
{
    protected $host;
    protected $user;
    protected $pass;
    protected $port;
    protected $queue;
    protected $scriptName;

    public function __construct()
    {
        $this->host = getenv('RABBIT_HOST');
        $this->user = getenv('RABBIT_USER');
        $this->pass = getenv('RABBIT_PASSWORD');
        $this->port = getenv('RABBIT_PORT');
    }

    public function processMessage($message)
    {
        // some process logic
    }

    public function startConsume($passive = false, $durable = true, $exclusive = false, $autoDelete = false)
    {

        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);

        $channel = $connection->channel();
        $channel->queue_declare($this->queue, $passive, $durable, $exclusive, $autoDelete);
        $channel->basic_consume($this->queue, '', false, true, false, false, array($this, 'processMessage'));
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

    public function isRunning()
    {
        exec('ps aux | grep ' . $this->scriptName . ' | grep -v grep', $output);
        if (empty($output)) {
            return false;
        } else {
            return true;
        }
    }


    public function runScript()
    {
        exec('php ' . APPLICATION_PATH . '/scripts/' . $this->scriptName . ' &', $oot);
    }
}