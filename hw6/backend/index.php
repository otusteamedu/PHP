<?php
require 'vendor/autoload.php';

header('Content-Type: text/plain; charset=utf-8');

$app = new hw6\App();
echo $app->run();