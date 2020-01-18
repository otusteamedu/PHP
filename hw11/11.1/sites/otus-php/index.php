<?php

declare(strict_types=1);

use App\Kernel\Application;

require 'vendor/autoload.php';

/** @var Application $app */
$app = new Application();
$result = $app->run();
$result->send();
