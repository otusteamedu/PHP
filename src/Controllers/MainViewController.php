<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/app.php';

use Controllers\MainController;
use Exceptions\RestClientException;
use Handlers\MainViewHandler;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$mainController = new MainController();

if (isset($_POST['name'])) {
    $name = MainViewHandler::validateInputData($_POST['name']);
    try {
        $result = $mainController->writeYoutubeData($name);
    } catch (RestClientException $e) {
    }
}

if (isset($_POST['show'])) {
    MainViewHandler::displayData($mainController);
}
