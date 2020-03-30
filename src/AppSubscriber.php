<?php declare(strict_types=1);

use Service\Amqp\SubscriberInterface;
use Service\Exception\UnknownCommandException;

class AppSubscriber
{
    public function resolveSubscriber(string $subscriberClass): SubscriberInterface
    {
        $subscriberClass = sprintf('Service\Amqp\Consumer\%sConsumer', $subscriberClass);
        if (!class_exists($subscriberClass)) {
            throw new UnknownCommandException(sprintf('Указан несуществующий класс %s', $subscriberClass));
        }

        return new $subscriberClass();
    }

    /**
     * @param array $args
     * @throws UnknownCommandException
     */
    public function run(array $args): void
    {
        if (empty($args[1])) {
            throw new UnknownCommandException('Необходимо указать класс консьюмера');
        }
        $subscriber = $this->resolveSubscriber($args[1]);
        $subscriber->run();
    }
}
