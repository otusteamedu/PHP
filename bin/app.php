#!/usr/bin/env php
<?php

use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

if (file_exists('.env')) {
    (new Dotenv(true))->load('.env');
}

/** @var \Psr\Container\ContainerInterface $container */
$container = require_once 'config/container.php';

$em = $container->get(EntityManagerInterface::class);
$connection = $em->getConnection();

$cli = new Application();

$configuration = new Doctrine\Migrations\Configuration\Configuration($connection);
$configuration->setMigrationsDirectory('migrations');
$configuration->setMigrationsNamespace('Migration');

$cli->getHelperSet()->set(new EntityManagerHelper($em), 'em');
$cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');

\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();
