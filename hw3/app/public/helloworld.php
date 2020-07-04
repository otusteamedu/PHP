<?php

use HelloWorld\HelloWorld;
use HelloWorld\Printer\Simple;

require_once('../vendor/autoload.php');

$printer = new Simple();
$helloWorld = new HelloWorld($printer);
$helloWorld->print('Hello world!');