<?php declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Documents', __DIR__);

$request = Request::createFromGlobals();

$app = new App();
$response = $app->run($request);
$response->send();
