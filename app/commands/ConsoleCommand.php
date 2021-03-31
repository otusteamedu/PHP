<?php

namespace Commands;

use Otus\Consumer\RabbitMQConsumers\BasicConsumers\ConsumerFactory;
use Otus\Exceptions\AppException;

class ConsoleCommand
{
    const BASIC_START = 'basic_start';

    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    /**
     * @throws AppException
     */
    public function run()
    {
        if (!empty($this->argv[1])) {
            switch ($this->argv[1]) {
                case self::BASIC_START:
                    $this->basicStart();
                    break;
                default:
                    throw new AppException('undefined command');
            }
        }
    }

    private function basicStart()
    {
        $basicConsumer = ConsumerFactory::createConsumer();
        $basicConsumer->start();
    }
}
