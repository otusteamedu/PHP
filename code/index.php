<?php
use code\src;
require __DIR__ . '/./vendor/autoload.php';
$app = new  src\Application();
echo $app->run();