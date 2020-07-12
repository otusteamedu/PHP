<?php

use App\Components\DI\MyDIContainer;
use App\Config;

$configuration = new Config(__DIR__ . '/configs/');
$configuration->add('routing', 'routes');

$diConfiguration = new Config(__DIR__ . '/app/');
$diConfiguration->add('di', 'di-config');

$container = new MyDIContainer($diConfiguration->get('di-config'));
