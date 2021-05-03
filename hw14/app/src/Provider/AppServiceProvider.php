<?php

declare(strict_types=1);

namespace App\Provider;

use App\Database\DbConnectionBuilder;
use App\Model\Film\DataMapper\FilmMapper;
use App\Model\Film\DataMapper\FilmMapperInterface;
use PDO;

class AppServiceProvider extends AbstractServiceProvider
{
    protected array $bindings = [
        FilmMapperInterface::class => FilmMapper::class,
    ];

    protected function addMoreBindings(): void
    {
        $this->addBindDbConnection();
    }

    private function addBindDbConnection(): void
    {
        $this->bindings[PDO::class] = function () {
            return (new DbConnectionBuilder())
                ->setDriver($this->config->getParam('db_driver'))
                ->setHost($this->config->getParam('db_host'))
                ->setPort(intval($this->config->getParam('db_port')))
                ->setDbName($this->config->getParam('db_name'))
                ->setUserName($this->config->getParam('db_username'))
                ->setPassword($this->config->getParam('db_password'))
                ->build();
        };
    }
}