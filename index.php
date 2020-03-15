<?php
require 'vendor/autoload.php';

use Ozycast\App\App;

$app = new App();
echo $app->run();