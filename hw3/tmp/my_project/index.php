<?php

require 'vendor/autoload.php';

use nlazarev\my_project\Model\Users\User;

$example = new User("Николай");

echo $example->getName() . PHP_EOL;
