<?php

use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = require 'config/container.php';

$em = $container->get(EntityManagerInterface::class);
$connection = $em->getConnection();

$configuration = new Doctrine\Migrations\Configuration\Configuration($connection);
$configuration->setMigrationsDirectory('migrations');
$configuration->setMigrationsNamespace('Migration');

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'configuration' => new ConfigurationHelper($connection, $configuration),
]);
