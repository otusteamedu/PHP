<?php

namespace Commands;

use hanneskod\classtools\Iterator\ClassIterator;
//use Otus\Consumer\RabbitMQConsumers\BasicConsumers\ConsumerA;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
//use Otus\View\View;
use Symfony\Component\Finder\Finder;

class ConsoleCommand
{
    const START_BASIC_CONSUMERS = 'start_basic';

    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    public function run()
    {
        if (!empty($this->argv[1])) {
            switch ($this->argv[1]) {
                case self::START_BASIC_CONSUMERS:
                    $this->startConsumers();
            }
        }
    }

    private function startConsumers()
    {
        $finder = new Finder;
        $iter = new ClassIterator($finder->in($_ENV['RABBITMQ_BASIC_CONSUMERS_PATH']));

        foreach ($iter->getClassMap() as $classname => $splFileInfo) {
            /** @var RabbitMQConsumer $consumer */
            $consumerClass = '\\' . $classname;
            $encoded = json_encode($consumerClass, JSON_UNESCAPED_UNICODE);
            exec('php consumerStarter.php ' . $encoded . '>/dev/null 2>&1 &');
        }
    }
}
