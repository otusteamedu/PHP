<?php
require 'vendor/autoload.php';

use Ozycast\Bracket\Bracket;

$app = new Bracket();
echo $app->run();