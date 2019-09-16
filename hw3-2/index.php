<?php
require 'vendor/autoload.php';

use Eantonov\PSR4\Demo;

$demo = new Demo;
echo $demo->hello() . PHP_EOL;
