<?php

require 'vendor/autoload.php';

use \Otus\Lessons\Lesson4\HelloWorld;



$example = new HelloWorld;
echo $example->getName() . PHP_EOL;