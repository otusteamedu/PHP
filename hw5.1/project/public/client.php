<?php
require __DIR__ . '/../vendor/autoload.php';

use AI\backend_php_hw5_1\ClientApp;

if (PHP_SAPI == 'cli') {
    $_SERVER['DOCUMENT_ROOT'] = __DIR__;
}

$app = new ClientApp();
$inputData = $app->getInput();
$result = $app->executeRequest('http://web/', $inputData);
$app->showResult($result);
