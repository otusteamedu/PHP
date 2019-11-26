<?php

require_once "../vendor/autoload.php";

use timga\packagist_test\SayHello;

$name = 'Otus';
$hello = new SayHello($name);
$hello->run();