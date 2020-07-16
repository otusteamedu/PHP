<?php

use App\Components\DI\MyDIContainer;
use App\Config;

$configuration = new Config(__DIR__ . '/configs/');
$configuration->add('routing', 'routes');
$configuration->add('rabbit','rabbit');
$configuration->add('di', 'di-config');

$container = new MyDIContainer($configuration->get('di-config'));
