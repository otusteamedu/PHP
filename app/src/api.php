<?php

namespace App;

use App\Db\Connect;
use App\Db\Repository;
use App\Service\ApiService;
use App\Service\RabbitService;
use Exception;

include_once __DIR__ . '/../vendor/autoload.php';

$config = new Config();
$connect = new Connect($config);
$repository = new Repository($connect);
$apiService = new ApiService($repository);

if (!isset($_GET['mode'])) {
    echo $apiService->getResponse(500, 'No mode passed');
    exit;
}

$data = file_get_contents('php://input');
$data = json_decode($data, true);

if ($_GET['mode'] === 'send') {
    try {
        echo $apiService->send($data, new RabbitService($config));
    } catch (Exception $exception) {
        echo $apiService->getResponse(500, $exception->getMessage());
    }
    exit;
}

if ($_GET['mode'] === 'get') {
    try {
        echo $apiService->get($data);
    } catch (Exception $exception) {
        echo $apiService->getResponse(500, $exception->getMessage());
    }
    exit;
}

echo $apiService->getResponse(500, 'Wrong api url');