<?php declare(strict_types=1);

use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$app = new AppConsole();
$app->run($argv);
