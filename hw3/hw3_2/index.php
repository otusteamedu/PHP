<?php
require 'vendor/autoload.php';
use Stepanova\PSR4\PACK;
$example = new Pack;
echo $example->check() . PHP_EOL;