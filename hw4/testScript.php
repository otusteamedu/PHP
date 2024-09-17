<?php
require  __DIR__ . '/myExtension/vendor/autoload.php';
use My\Extensions\MyExtension;
$example = new MyExtension;
echo $example->getName() . PHP_EOL;