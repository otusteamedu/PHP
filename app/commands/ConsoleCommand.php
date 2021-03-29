<?php

namespace Commands;

use Otus\Consumer\RabbitMQConsumers\BasicConsumers\ConsumerA;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Exceptions\AppException;

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

    //запускает всех Consumer-ов в фоновом режиме
    private function startConsumers()
    {

    }

    private function basicStart()
    {
        $basicConsumer = new ConsumerA();
        $basicConsumer->start();
    }

    private function backgroundStart()
    {
        $className = ConsumerA::class;
        $encoded = json_encode('\\' . $className);
        exec('php consumerStarter.php ' . $encoded . '>/dev/null 2>&1 &');
    }

}
