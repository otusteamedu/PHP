<?php

use App\Utils\Config;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = (new Config)->buildContainer();

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
