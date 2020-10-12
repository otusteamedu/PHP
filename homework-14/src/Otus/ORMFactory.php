<?php

namespace Otus;

use Otus\Config\Config;
use Otus\Database\ConnectionFactory;
use Otus\Entities\MailMapper;

class ORMFactory
{
    public static function make(): ORM
    {
        $config = Config::getInstance();
        $pdo    = ConnectionFactory::make($config)->getPdo();
        $mapper = new MailMapper($pdo);

        $map    = IdentityMap::make();

        return new ORM($mapper, $map);
    }
}