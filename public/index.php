<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use HomeWork\App;

require_once 'config.php';
/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$app->run($argv);
