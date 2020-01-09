<?php

use AlexanderVasiliev23\Person;

require_once 'vendor/autoload.php';

$person = new Person('John');

echo $person->greet() . PHP_EOL;
