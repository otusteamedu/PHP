<?php

use App\Core\App;

require_once __DIR__ . '/src/autoload.php';

$app = new App($configuration);
$app->run();