<?php

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\ServiceManager\ServiceManager;

$aggregator = new ConfigAggregator([
    new ArrayProvider([
        ConfigAggregator::ENABLE_CACHE => false,
        ConfigAggregator::CACHE_FILEMODE => 0600,
    ]),
    new PhpFileProvider('config/common/*.php'),
    new PhpFileProvider('config/' . (getenv('APP_ENV') ?: 'prod') . '/*.php'),
    new PhpFileProvider('config/' . (getenv('APP_ENV') ?: 'prod') . '/*.local.php'),
], 'var/cache/config.php');

$config = $aggregator->getMergedConfig();

$container = new ServiceManager($config['dependencies']);
$container->setService('config', $config['config']);

return $container;
