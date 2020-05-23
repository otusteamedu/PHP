#!/usr/bin/env php
<?php

use App\Console\Command\FixtureLoaderCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require_once 'config/container.php';

$config = $container->get('config');

$cli = new Application();
$cli->add(new FixtureLoaderCommand($container->get(EntityManagerInterface::class), $config['fixture']['dir']));
$cli->run();
