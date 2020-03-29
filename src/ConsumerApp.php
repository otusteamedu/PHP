<?php declare(strict_types=1);

use Service\Amqp\Consumer\AbstractConsumer;
use Service\Exception\UnknownCommandException;

class ConsumerApp
{
    public function resolveConsumer(string $consumerClass): AbstractConsumer
    {
        $consumerClass = sprintf('Service\Amqp\Consumer\%sConsumer', $consumerClass);

        return new $consumerClass();
    }

    public function run(array $args): void
    {
        if (empty($args[1])) {
            throw new UnknownCommandException('Необходимо указать класс консьюмера');
        }
        $consumer = $this->resolveConsumer($args[1]);
        $consumer->run();
    }
}
