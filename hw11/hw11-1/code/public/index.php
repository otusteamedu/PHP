<?php


require_once '../vendor/autoload.php';

use YoutubeApp\Controller;
use YoutubeApp\View;

$run = new Controller();
$view = new View();

$run->run();
$view->view();

echo "<pre>";
print_r($view->getTopChannel());
echo PHP_EOL;
echo PHP_EOL;
print_r($view->getAllDataChannel());
echo "</pre";