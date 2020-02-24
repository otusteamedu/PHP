<?php
require 'vendor/autoload.php';

use Ozycast\Socket\Socket;

$app = new Socket();
echo $app->run($argv);