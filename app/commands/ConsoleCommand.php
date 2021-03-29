<?php

namespace Commands;

use hanneskod\classtools\Iterator\ClassIterator;
use Otus\Consumer\RabbitMQConsumers\BasicConsumers\ConsumerA;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Exceptions\AppException;
use Symfony\Component\Finder\Finder;

class ConsoleCommand
{
    const BASIC_START = 'basic_start';
    const BACKGROUND_START = 'background_start';

    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    public function run()
    {
        if (!empty($this->argv[1])) {
            switch ($this->argv[1]) {
                case self::BASIC_START:
                    $this->basicStart();
                    break;
                case self::BACKGROUND_START:
                    $this->backgroundStart();
                    break;
                default:
                    throw new AppException('undefined command');
            }
        }
    }

    private function basicStart()
    {
        $basicConsumer = new ConsumerA();
        $basicConsumer->start();
    }

    /**
     * найдет всех Consumer-ов
     * из RABBITMQ_BASIC_CONSUMERS_PATH
     * и запустит в фоновом режиме
     */
    private function backgroundStart()
    {
        $finder = new Finder;
        $iter = new ClassIterator($finder->in($_ENV['RABBITMQ_BASIC_CONSUMERS_PATH']));

        foreach ($iter->getClassMap() as $classname => $splFileInfo) {
            $consumerClass = '\\' . $classname;
            $encoded = json_encode($consumerClass);

            exec('php consumerStarter.php ' . $encoded . '>/dev/null 2>&1 &');
        }
    }
}
