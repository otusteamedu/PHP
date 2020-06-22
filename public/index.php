<?php

declare(strict_types=1);

define("ROOT", dirname(__DIR__) . '/');

use Composer\Autoload\ClassLoader;
use HomeWork\App;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$app->run($argv);
