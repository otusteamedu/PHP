<?php

namespace Otus\Console;

use Dotenv\Dotenv;
use Otus\Config\Config;
use Otus\Queue\ConnectionFactory;
use Otus\Queue\QueueContract;

class App
{
    private string $basePath;

    private Config $config;

    private QueueContract $queue;

    public function __construct(string $path)
    {
        $this->basePath = $path;

        $this->loadEnvironment()
             ->loadConfiguration()
             ->loadQueue();
    }

    public function run(): void
    {
        while (true) {
            $message = $this->queue->pop($this->config->get('queues.rabbitmq.queue'));

            if ($message->getData()) {
                echo "Message received: ".$message->getData().PHP_EOL;
            }

            sleep(1);
        }
    }

    private function loadEnvironment(): self
    {
        $dotenv = Dotenv::createImmutable($this->basePath);
        $dotenv->load();

        return $this;
    }

    private function loadConfiguration(): self
    {
        $this->config = Config::getInstance($this->basePath.'config/app.php');

        return $this;
    }

    private function loadQueue(): self
    {
        $connection  = ConnectionFactory::make($this->config);
        $this->queue = $connection->connect($this->config);

        return $this;
    }
}
