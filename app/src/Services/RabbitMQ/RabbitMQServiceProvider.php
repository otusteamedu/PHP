<?php


namespace App\Services\RabbitMQ;

use App\Services\RabbitMQ\Consumers\GetReportConsumer;
use App\Services\RabbitMQ\DTO\SourceBindDto;
use App\Services\RabbitMQ\Exchanges\DefaultExchange;
use App\Services\RabbitMQ\Logger\ConsumerMessageLogger;
use App\Services\RabbitMQ\Publishers\ReportPublisher;
use App\Services\RabbitMQ\Queues\DefaultQueue;
use App\Services\ServiceContainer\AppServiceContainer;

class RabbitMQServiceProvider
{
    private Manager $manager;
    private EventDispatcher $eventDispatcher;

    public function __construct()
    {
        $serviceContainer = AppServiceContainer::getInstance();
        $this->manager = $serviceContainer->resolve(Manager::class);
        $this->eventDispatcher = $serviceContainer->resolve(EventDispatcher::class);
    }

    public function boot() : void
    {
        $queue = new DefaultQueue();
        $exchange = new DefaultExchange();

        $this->manager->declareQueue($queue);
        $this->manager->declareExchange($exchange);
        $this->manager->bindQueue($queue, $exchange, new SourceBindDto());

        $consumer = new GetReportConsumer($queue);
        $consumer->setLogger(new ConsumerMessageLogger());
        $this->manager->initConsumer($consumer);

        $this->eventDispatcher->pushPublisher(new ReportPublisher($exchange));
    }

}