<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\ServiceManager\ServiceManager;

$aggregator = new ConfigAggregator([
    new PhpFileProvider('config/common/*.php'),
    new PhpFileProvider('config/local/*.php'),
]);

$config = $aggregator->getMergedConfig();

$container = new ServiceManager($config['dependencies']);
$container->setService('config', $config['config']);

return $container;
