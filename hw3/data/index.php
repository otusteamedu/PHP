"START" <br>
<?php
require 'vendor/autoload.php';

use Pack\Lessons\Lesson4\Example;
use Pack\Lessons\Lesson5\Example as Ls5;

$example = new Example();
echo $example->getName().PHP_EOL;
echo "<br>";
$example1 = new Ls5();
echo $example1->getName().PHP_EOL;

echo "<br>START php".PHP_EOL;
echo "<br>START php".PHP_EOL;
//echo phpinfo();