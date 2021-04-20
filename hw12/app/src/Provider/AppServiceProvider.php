<?php

declare(strict_types=1);

namespace App\Provider;

use App\Builder\RedisClientBuilder;
use App\Model\Event\Repository\EventRepositoryInterface;
use App\Model\Event\Repository\RedisEventRepository;
use Averias\RedisJson\Client\RedisJsonClientInterface;

class AppServiceProvider extends AbstractServiceProvider
{

    protected array $bindings = [
        EventRepositoryInterface::class => RedisEventRepository::class,
    ];

    protected function addMoreBindings(): void
    {
        $this->addBindRedisClient();
    }

    private function addBindRedisClient(): void
    {
        $this->bindings[RedisJsonClientInterface::class] = function () {
            return (new RedisClientBuilder())
                ->setHost($this->config->getParam('redis_host'))
                ->setPort(intval($this->config->getParam('redis_port')))
                ->setPassword($this->config->getParam('redis_password'))
                ->setDbIndex(intval($this->config->getParam('redis_db')))
                ->build();
        };
    }

}